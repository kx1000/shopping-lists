<?php


namespace App\Utils\Report;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ShoppingListRepository;

class CategoriesMonthsReport implements ReportInterface
{
    private $labels;

    private $shoppingListRepository;
    private $categoryRepository;

    public function __construct(ShoppingListRepository $shoppingListRepository, CategoryRepository $categoryRepository)
    {
        $this->shoppingListRepository = $shoppingListRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function init(): void
    {
        $this->buildLabels();
    }

    private function buildLabels(): void
    {
        $this->labels = array_map(
            function(array $item) {
                return $item['YearMonth'];
            },
            $this->shoppingListRepository->getMonthsReportLabels()
        );
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function buildDatasets(): array
    {
        $datasets = [];

        foreach ($this->categoryRepository->findAll() as $category) {
            $datasets[] = [
                'label' => $category->getName(),
                'backgroundColor' => $category->getColor(),
                'data' => $this->buildSumArrayForCategory($category),
            ];
        }

        $datasets[] = [
            'label' => 'null',
            'backgroundColor' => null,
            'data' => $this->buildSumArrayForCategory(null),
        ];

        return $datasets;
    }

    private function buildSumArrayForCategory(?Category $category): array
    {
        $sourceData = $this->shoppingListRepository->getMonthReportDataByCategory($category);
        $resultData = [];
        foreach ($this->getLabels() as $label) {
            $resultData[] = $this->findSumByLabel($label, $sourceData);
        }

        return $resultData;
    }

    private function findSumByLabel(string $label, array $data): float
    {
        foreach ($data as $item) {
            if ($label === $item['YearMonth']) {
                return $item['monthSum'];
            }
        }

        return 0;
    }
}