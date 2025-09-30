<?php
namespace App\Controller;

use App\Form\PetType;
use App\Service\PetApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PetController extends AbstractController
{
    public function __construct(private PetApiClient $api) {}

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/pet/find', name: 'pet_find')]
    public function find(Request $request): Response
    {
        $id = $request->query->getInt('id');
        if ($id > 0) {
            return $this->redirectToRoute('pet_show', ['id' => $id]);
        }

        $this->addFlash('danger', 'Please enter a valid Pet ID');
        return $this->redirectToRoute('home');
    }

    #[Route('/pet/{id}', name: 'pet_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        try {
            $pet = $this->api->getPet($id);
            return $this->render('pet_show.html.twig', ['pet' => $pet]);
        } catch (\Throwable) {
            $this->addFlash('danger', "Pet $id not found!");
            return $this->redirectToRoute('home');
        }
    }

    #[Route('/pet/add', name: 'pet_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(PetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $response = $this->api->addPet($form->getData());
                $id = (int) ($response['id'] ?? 0);

                if ($id > 0) {
                    $this->addFlash('success', "Pet $id added!");
                    return $this->redirectToRoute('pet_show', ['id' => $id]);
                }

                $this->addFlash('warning', 'Pet added but no ID returned by API');
                return $this->redirectToRoute('home');
            } catch (\Throwable $e) {
                $this->addFlash('danger', 'Error adding Pet: ' . $e->getMessage());
            }
        }

        return $this->render('pet_form.html.twig', [
            'form' => $form->createView(),
            'action' => 'Add'
        ]);
    }

    #[Route('/pet/edit/{id}', name: 'pet_edit', requirements: ['id' => '\d+'])]
    public function edit(int $id, Request $request): Response
    {
        try {
            $pet = $this->api->getPet($id);
        } catch (\Throwable) {
            $this->addFlash('danger', "Pet $id not found!");
            return $this->redirectToRoute('home');
        }
//        dd($pet);
        // Extract only the fields needed for the form
        $petData = [
            'id' => $pet['id'] ?? null,
            'name' => $pet['name'] ?? null,
            'status' => $pet['status'] ?? null,
        ];

        $form = $this->createForm(PetType::class, $petData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $response = $this->api->updatePet($form->getData());
                $newId = (int) ($response['id'] ?? $id);

                $this->addFlash('success', "Pet $newId updated!");
                return $this->redirectToRoute('pet_show', ['id' => $newId]);
            } catch (\Throwable $e) {
                $this->addFlash('danger', 'Error updating Pet: ' . $e->getMessage());
            }
        }

        return $this->render('pet_form.html.twig', [
            'form' => $form->createView(),
            'action' => 'Edit'
        ]);
    }

    #[Route('/pet/delete/{id}', name: 'pet_delete', requirements: ['id' => '\d+'])]
    public function delete(int $id, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            try {
                $this->api->deletePet($id);
                $this->addFlash('success', "Pet $id deleted!");
                return $this->redirectToRoute('home');
            } catch (\Throwable $e) {
                $this->addFlash('danger', "Error deleting Pet $id: " . $e->getMessage());
            }
        }

        return $this->render('pet_delete.html.twig', ['id' => $id]);
    }
}
