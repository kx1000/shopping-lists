<?php


namespace App\Utils;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Filter
{
    /** @var FormInterface */
    private $form;
    private $filters;
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->filters = [];
        $this->requestStack = $requestStack;
    }

    public function initializeForm(FormInterface $form): self
    {
        $this->form = $form;
        $this->form->handleRequest($this->requestStack->getCurrentRequest());

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