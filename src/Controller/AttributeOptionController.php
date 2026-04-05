<?php

namespace App\Controller;

use App\Entity\AttributeOption;
use App\Form\AttributeOptionType;
use App\Repository\AttributeOptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/attribute/option')]
final class AttributeOptionController extends AbstractController
{
    #[Route(name: 'app_attribute_option_index', methods: ['GET'])]
    public function index(AttributeOptionRepository $attributeOptionRepository): Response
    {
        return $this->render('attribute_option/index.html.twig', [
            'attribute_options' => $attributeOptionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_attribute_option_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $attributeOption = new AttributeOption();
        $form = $this->createForm(AttributeOptionType::class, $attributeOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($attributeOption);
            $entityManager->flush();

            return $this->redirectToRoute('app_attribute_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('attribute_option/new.html.twig', [
            'attribute_option' => $attributeOption,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attribute_option_show', methods: ['GET'])]
    public function show(AttributeOption $attributeOption): Response
    {
        return $this->render('attribute_option/show.html.twig', [
            'attribute_option' => $attributeOption,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_attribute_option_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AttributeOption $attributeOption, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AttributeOptionType::class, $attributeOption);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_attribute_option_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('attribute_option/edit.html.twig', [
            'attribute_option' => $attributeOption,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attribute_option_delete', methods: ['POST'])]
    public function delete(Request $request, AttributeOption $attributeOption, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributeOption->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($attributeOption);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_attribute_option_index', [], Response::HTTP_SEE_OTHER);
    }
}
