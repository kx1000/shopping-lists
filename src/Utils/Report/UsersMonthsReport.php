<?php


namespace App\Utils\Report;


use App\Repository\ShoppingListRepository;
use App\Repository\UserRepository;

class UsersMonthsReport implements ReportInterface
{
    private $labels;

    private $shoppingListRepository;
    private $userRepository;

    public function __construct(ShoppingListRepository $shoppingListRepository, UserRepository $userRepository)
    {
        $this->shoppingListRepository = $shoppingListRepository;
        $this->userRepository = $userRepository;
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

        foreach ($this->userRepository->findAll() as $user) {
            $datasets[] = [
                'label' => $user->getEmail(),
                'borderColor' => $user->getColor(),
                'data' => $this->buildSumArrayForEmail($user->getEmail()),
            ];
        }

        $datasets[] = [
            'label' => 'Total',
            'borderColor' => 'black',
            'data' => $this->buildSumArrayForEmail(null),
        ];

        return $datasets;
    }

    private function buildSumArrayForEmail(?string $email): array
    {
        $sourceData = $this->shoppingListRepository->getMonthReportDataByEmail($email);
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