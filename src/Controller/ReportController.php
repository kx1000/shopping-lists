<?php

namespace App\Controller;

use App\Utils\Report\CategoriesMonthsReport;
use App\Utils\Report\UsersMonthsReport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

/**
 * @Route("/in/report")
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/", name="report")
     */
    public function index(UsersMonthsReport $usersMonthsReport, CategoriesMonthsReport $categoriesMonthsReport, ChartBuilderInterface $chartBuilder): Response
    {
        $usersMonthsReport->init();
        $usersChart = $chartBuilder
            ->createChart(Chart::TYPE_LINE)
            ->setData([
                'labels' => $usersMonthsReport->getLabels(),
                'datasets' => $usersMonthsReport->buildDatasets(),
            ]);

        $categoriesMonthsReport->init();
        $categoriesChart = $chartBuilder
            ->createChart(Chart::TYPE_BAR)
            ->setData([
                'labels' => $categoriesMonthsReport->getLabels(),
                'datasets' => $categoriesMonthsReport->buildDatasets(),
            ]);

        return $this->render('report/index.html.twig', [
            'users_chart' => $usersChart,
            'categories_chart' => $categoriesChart,
        ]);
    }
}
