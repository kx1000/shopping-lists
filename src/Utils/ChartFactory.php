<?php


namespace App\Utils;

use App\Utils\Report\ReportInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartFactory
{
    private $chartBuilder;

    public function __construct(ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
    }

    public function create(string $type, ReportInterface $report): Chart
    {
        $report->init();
        return $this->chartBuilder
            ->createChart($type)
            ->setData([
                'labels' => $report->getLabels(),
                'datasets' => $report->buildDatasets(),
            ]);
    }
}