<?php


namespace App\Utils;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Filter
{
    /** @var FormInterface */
    private $form;
    private $requestStack;
    private $session;

    public function __construct(RequestStack $requestStack, SessionInterface $session)
    {
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

    public function initializeForm(FormInterface $form): self
    {
        $this->form = $form;
        $this->form->setData($this->getFilters());
        $this->form->handleRequest($this->requestStack->getCurrentRequest());

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->session->set('filters', $this->form->getData());
        }

        return $this;
    }

    public function getFilters(): array
    {
        return $this->session->get('filters', []);
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}