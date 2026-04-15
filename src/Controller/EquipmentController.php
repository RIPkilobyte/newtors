<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Repository\EquipmentRepository;
use App\Repository\EquipmentTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/equipment')]
final class EquipmentController extends AbstractController
{
    #[Route(name: 'equipment_index', methods: ['GET'])]
    public function index(EquipmentRepository $equipmentRepository): Response
    {
        return $this->render('equipment/index.html.twig', [
            'equipment' => $equipmentRepository->findAll(),
        ]);
    }

    #[Route('/api', name: 'equipment_api', methods: ['GET'])]
    public function api(Request $request, EquipmentRepository $repository): JsonResponse
    {
        $user = $this->getUser();
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('size', 20);
        $filters = $request->query->all('filter');

        $result = $repository->findByFilters($user, $filters, $page, $limit);

//        return new JsonResponse([
//            'data' => [],
//            'total' => $result['total'],
//            'last_page' => round($result['total'] / $limit, 0),
//        ]);
//        dd([
//            'data' => [],
//            'total' => $result['total'],
//            'last_page' => round($result['total'] / $limit, 0),
//        ]);

        return $this->json([
            'data' => $result['data'],
            'total' => $result['total'],
            'last_page' => max(1, (int) ceil($result['total'] / $limit)),
        ]);
    }

    #[Route('/new', name: 'equipment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipment = new Equipment();
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipment);
            $entityManager->flush();

            return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipment/new.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'equipment_show', methods: ['GET'])]
    public function show(Equipment $equipment): Response
    {
        return $this->render('equipment/show.html.twig', [
            'equipment' => $equipment,
        ]);
    }

    #[Route('/{id}/edit', name: 'equipment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipment $equipment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipment/edit.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'equipment_delete', methods: ['POST'])]
    public function delete(Request $request, Equipment $equipment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($equipment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipment_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/equipment/attributes/{typeId}', name: 'equipment_attributes_by_type')]
    public function getAttributesByType(int $typeId, EquipmentTypeRepository $typeRepo): JsonResponse
    {
        $type = $typeRepo->find($typeId);
        if (!$type) {
            return $this->json([]);
        }
        $attributesData = [];
        foreach ($type->getTypeAttributes() as $typeAttr) {
            $attr = $typeAttr->getAttribute();
            $options = [];
            if ($attr->isMultiple()) {
                foreach ($attr->getOptions() as $opt) {
                    $options[] = ['value' => $opt->getValue(), 'label' => $opt->getLabel()];
                }
            }
            $attributesData[] = [
                'id' => $attr->getId(),
                'name' => $attr->getName(),
                'label' => $attr->getLabel(),
                'dataType' => $attr->getDataType(),
                'isMultiple' => $attr->isMultiple(),
                'required' => $typeAttr->isRequired(),
                'options' => $options,
            ];
        }
        return $this->json($attributesData);
    }
}
