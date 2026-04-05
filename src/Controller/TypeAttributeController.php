<?php

namespace App\Controller;

use App\Entity\TypeAttribute;
use App\Form\TypeAttributeType;
use App\Repository\TypeAttributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/attribute')]
final class TypeAttributeController extends AbstractController
{
    #[Route(name: 'app_type_attribute_index', methods: ['GET'])]
    public function index(TypeAttributeRepository $typeAttributeRepository): Response
    {
        return $this->render('type_attribute/index.html.twig', [
            'type_attributes' => $typeAttributeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_attribute_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeAttribute = new TypeAttribute();
        $form = $this->createForm(TypeAttributeType::class, $typeAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeAttribute);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_attribute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_attribute/new.html.twig', [
            'type_attribute' => $typeAttribute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_attribute_show', methods: ['GET'])]
    public function show(TypeAttribute $typeAttribute): Response
    {
        return $this->render('type_attribute/show.html.twig', [
            'type_attribute' => $typeAttribute,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_attribute_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeAttribute $typeAttribute, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeAttributeType::class, $typeAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_attribute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_attribute/edit.html.twig', [
            'type_attribute' => $typeAttribute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_attribute_delete', methods: ['POST'])]
    public function delete(Request $request, TypeAttribute $typeAttribute, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeAttribute->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeAttribute);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_attribute_index', [], Response::HTTP_SEE_OTHER);
    }
}
