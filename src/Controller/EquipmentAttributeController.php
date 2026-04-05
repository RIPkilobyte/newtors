<?php

namespace App\Controller;

use App\Entity\EquipmentAttribute;
use App\Form\EquipmentAttributeType;
use App\Repository\EquipmentAttributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/equipment/attribute')]
final class EquipmentAttributeController extends AbstractController
{
    #[Route(name: 'app_equipment_attribute_index', methods: ['GET'])]
    public function index(EquipmentAttributeRepository $equipmentAttributeRepository): Response
    {
        return $this->render('equipment_attribute/index.html.twig', [
            'equipment_attributes' => $equipmentAttributeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_equipment_attribute_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipmentAttribute = new EquipmentAttribute();
        $form = $this->createForm(EquipmentAttributeType::class, $equipmentAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipmentAttribute);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipment_attribute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipment_attribute/new.html.twig', [
            'equipment_attribute' => $equipmentAttribute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipment_attribute_show', methods: ['GET'])]
    public function show(EquipmentAttribute $equipmentAttribute): Response
    {
        return $this->render('equipment_attribute/show.html.twig', [
            'equipment_attribute' => $equipmentAttribute,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_equipment_attribute_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipmentAttribute $equipmentAttribute, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EquipmentAttributeType::class, $equipmentAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_equipment_attribute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipment_attribute/edit.html.twig', [
            'equipment_attribute' => $equipmentAttribute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipment_attribute_delete', methods: ['POST'])]
    public function delete(Request $request, EquipmentAttribute $equipmentAttribute, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipmentAttribute->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($equipmentAttribute);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipment_attribute_index', [], Response::HTTP_SEE_OTHER);
    }
}
