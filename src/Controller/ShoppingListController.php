<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use App\Form\ShoppingListFilterType;
use App\Form\ShoppingListType;
use App\Repository\ShoppingListRepository;
use App\Utils\Filter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/in/shopping_list")
 */
class ShoppingListController extends AbstractController
{
    const LIST_SIZE = 5;

    /**
     * @Route(
     *     "/{page}",
     *     requirements={"page"="\d+"},
     *     name="shopping_list_index",
     *     methods={"GET", "POST"}
     * )
     */
    public function index(
        ShoppingListRepository $shoppingListRepository,
        Filter $filter,
        PaginatorInterface $paginator,
        int $page = 1
    ): Response {
        $filter->initializeForm($this->createForm(ShoppingListFilterType::class));
        return $this->render('shopping_list/index.html.twig', [
            'shopping_lists' => $paginator->paginate($shoppingListRepository->loadByFiltersQB($filter->getFilters()), $page, self::LIST_SIZE),
            'filter_form' => $filter->getForm()->createView(),
            'summaries' => $shoppingListRepository->getSummaries($filter->getFilters()),
        ]);
    }

    /**
     * @Route(
     *     "/new",
     *     name="shopping_list_new",
     *     methods={"GET","POST"}
     * )
     */
    public function new(Request $request): Response
    {
        $shoppingList = new ShoppingList($this->getUser());
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shoppingList);
            $entityManager->flush();

            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->render('shopping_list/new.html.twig', [
            'shopping_list' => $shoppingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id"="\d+"},
     *     name="shopping_list_edit",
     *     methods={"GET","POST"}
     * )
     */
    public function edit(Request $request, ShoppingList $shoppingList): Response
    {
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shopping_list_index');
        }

        return $this->render('shopping_list/edit.html.twig', [
            'shopping_list' => $shoppingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/{id}",
     *     requirements={"id"="\d+"},
     *     name="shopping_list_delete",
     *     methods={"DELETE"}
     * )
     */
    public function delete(Request $request, ShoppingList $shoppingList): Response
    {
        if ($this->isCsrfTokenValid('delete'.$shoppingList->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($shoppingList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('shopping_list_index');
    }
}
