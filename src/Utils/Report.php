<?php


namespace App\Utils;


use App\Repository\ShoppingListRepository;

class Report
{
    private $labels;

    private $shoppingListRepository;

    public function __construct(ShoppingListRepository $shoppingListRepository)
    {
        $this->shoppingListRepository = $shoppingListRepository;
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
            $this->shoppingListRepository->getMonthReportLabels()
        );
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function buildData(): array
    {
        return [];
    }
}