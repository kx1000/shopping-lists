<?php

namespace App\Controller;

use App\Utils\Report;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ReportController extends AbstractController
{
    /**
     * @Route("/report", name="report")
     */
    public function index(Report $report, ChartBuilderInterface $chartBuilder): Response
    {
        $report->init();

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $report->getLabels(),
            'datasets' => $report->buildDatasets(),
        ]);

        return $this->render('report/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
