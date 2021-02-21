<?php


namespace App\Utils;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;

class FilterForm
{
    private $type;
    /** @var FormInterface */
    private $form;
    private $filters;

    public function __construct()
    {
        $this->filters = [];
    }

    public function startWithFilterType(string $type): self
    {
        $this->type = $type;
        $this->form = Forms::createFormFactory()->create($this->type);
        $this->form->handleRequest();

        if ($this->form->isSubmitted() && $this->form->isValid()) {
             $this->filters = $this->form->getData();
        }

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}