<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Form\ProductsForm;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products')]
final class ProductsController extends AbstractController
{
    #[Route(name: 'app_products_index', methods: ['GET'])]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
            'products'=>[],
        ]);
    }

    #[Route('/new/{id}', name: 'app_products_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Categories $categorie): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCategories($categorie);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products_categories', ['id'=>$categorie->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_products_categories', methods: ['GET'])]
    public function showCategories(Categories $categories, ProductsRepository $productsRepository): Response
    {
        return $this->render('products/productCategories.html.twig', [
            'products' => $productsRepository->findBy(['categories'=>$categories]),
            'categories'=>$categories,
        ]);
    }
    #[Route('/categories/{id}', name: 'app_products_show', methods: ['GET'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product'=>$product
        ]);
    }


    #[Route('/{id}/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductsForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_products_categories', ['id'=>$product->getCategories()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_products_categories', ['id'=>$product->getCategories()->getId()], Response::HTTP_SEE_OTHER);
    }
}
