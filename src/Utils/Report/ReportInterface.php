<?php


namespace App\Utils\Report;


interface ReportInterface
{
    public function init(): void;
    public function getLabels(): array;
    public function buildDatasets(): array;
}