<?php

namespace App\Controller;

use App\Utils\ChartFactory;
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
    public function index(UsersMonthsReport $usersMonthsReport, CategoriesMonthsReport $categoriesMonthsReport, ChartFactory $chartFactory): Response
    {
        return $this->render('report/index.html.twig', [
            'users_chart' => $chartFactory->create(Chart::TYPE_LINE, $usersMonthsReport),
            'categories_chart' => $chartFactory->create(Chart::TYPE_BAR, $categoriesMonthsReport),
        ]);
    }
}
