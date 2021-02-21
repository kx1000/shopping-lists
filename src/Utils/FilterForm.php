<?php


namespace App\Utils;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterForm
{
    private $type;
    /** @var FormInterface */
    private $form;

    public function startWithFilterType(string $type): self
    {
        $this->type = $type;
        $this->form = Forms::createFormFactory()->create($this->type);

        return $this;
    }

    public function getFilters(): array
    {
        $this->form->handleRequest();

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->form->getData();
        }

        return [];
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}