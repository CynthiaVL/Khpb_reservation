<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Property;
use App\Form\PropertyStepFourType;
use App\Form\PropertyStepOneType;
use App\Form\PropertyStepThreeType;
use App\Form\PropertyStepTwoType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/property')]
class PropertyController extends AbstractController
{
    #[Route('/', name: 'app_property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/new/{step}', name: 'app_property_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, int $step): Response
    {
        $property = $request->getSession()->get('property', new Property());

        switch ($step) {
            case 1:
                $form = $this->createForm(PropertyStepOneType::class, $property);
                break;
            case 2:
                $form = $this->createForm(PropertyStepTwoType::class, $property);
                break;
            case 3:
                $form = $this->createForm(PropertyStepThreeType::class, $property);
                break;
            case 4:
                $form = $this->createForm(PropertyStepFourType::class, $property);
                break;
            default:
                return $this->redirectToRoute('app_property_new', ['step' => 1]);
        }
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder temporairement l'objet Property dans la session
            $request->getSession()->set('property', $property);
    
            if ($step == 2) {

                /** @var UploadedFile[] $imageFiles */
                $imageFiles = $form->get('link')->getData();

                if ($imageFiles) {
                    foreach ($imageFiles as $imageFile) {
                        if (!$imageFile instanceof UploadedFile) {
                            throw new \Exception('Invalid file upload');
                        }
                        // Générer un nom de fichier unique
                        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                        // Enlève les caractères non recommandés dans le nom du fichier
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                        // Déplacer le fichier dans le répertoire configuré
                        try {
                            $imageFile->move(
                                $this->getParameter('images_directory'),
                                $newFilename
                            );

                            // Créer et associer l'entité Image
                            $image = new Image();
                            $image->setLink($newFilename);
                            $image->setProperty($property);
                            $entityManager->persist($image);
                        } catch (FileException $e) {
                            // Gérer l'erreur si le fichier ne peut pas être déplacé
                            $this->addFlash('danger', 'Failed to upload the image.');
                        }
                    }

                    $entityManager->persist($property);
                }

            }
            if ($step == 4) {
                $entityManager->flush();
                $request->getSession()->remove('property');
                return $this->redirectToRoute('app_property_list');
            }
            return $this->redirectToRoute('app_property_new', ['step' => $step + 1]);
        }
    
        return $this->render('property/new.html.twig', [
            'form' => $form->createView(),
            'step' => $step,
        ]);
    }

    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[Route('/edit/{id}/{step}', name: 'app_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, EntityManagerInterface $entityManager, int $step = 1): Response
    {
        switch ($step) {
            case 1:
                $form = $this->createForm(PropertyStepOneType::class, $property);
                break;
            case 2:
                $form = $this->createForm(PropertyStepTwoType::class, $property);
                break;
            case 3:
                $form = $this->createForm(PropertyStepThreeType::class, $property);
                break;
            case 4:
                $form = $this->createForm(PropertyStepFourType::class, $property);
                break;
            
            default:
                return $this->redirectToRoute('app_property_new', ['step' => 1]);
                break;
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($step == 4) {
                $entityManager->flush();

                return $this->redirectToRoute('app_property_list');
            }

            return $this->redirectToRoute('app_property_new', ['step' => $step + 1]);
        }

        return $this->render('property/new.html.twig', [
            'form' => $form->createView(),
            'step' => $step,
            'property' => $property,
        ]);
    }

    #[Route('/{id}', name: 'app_property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
    }
}
