<?php

namespace App\Controller;

use App\Repository\ShoppingListRepository;
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
    public function index(ShoppingListRepository $shoppingListRepository, ChartBuilderInterface $chartBuilder): Response
    {
        dd($shoppingListRepository->getMonthReport());

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
                [
                    'label' => 'My second dataset',
                    'borderColor' => 'rgb(50, 50, 50)',
                    'data' => [10, 20, 15, 22, 50, 10, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => 100]],
                ],
            ],
        ]);

        return $this->render('report/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
