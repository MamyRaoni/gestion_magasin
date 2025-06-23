<?php

namespace App\Controller;

use App\Entity\CommandeProducts;
use App\Form\CommandeProductsForm;
use App\Repository\CommandeProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/makecommande')]
final class CommandeProductsController extends AbstractController
{
    #[Route(name: 'app_commande_products_index', methods: ['GET'])]
    public function index(CommandeProductsRepository $commandeProductsRepository): Response
    {
        return $this->render('commande_products/index.html.twig', [
            'commande_products' => $commandeProductsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_products_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commandeProduct = new CommandeProducts();
        $form = $this->createForm(CommandeProductsForm::class, $commandeProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandeProduct);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande_products/new.html.twig', [
            'commande_product' => $commandeProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_products_show', methods: ['GET'])]
    public function show(CommandeProducts $commandeProduct): Response
    {
        return $this->render('commande_products/show.html.twig', [
            'commande_product' => $commandeProduct,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommandeProducts $commandeProduct, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeProductsForm::class, $commandeProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_products_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande_products/edit.html.twig', [
            'commande_product' => $commandeProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_products_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeProducts $commandeProduct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeProduct->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($commandeProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_products_index', [], Response::HTTP_SEE_OTHER);
    }
}
