<?php

namespace App\Controller\Admin;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use App\Service\FileService;
use App\Service\StringService;
use App\Repository\InstrumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;


class AdminController extends AbstractController
{
    // ROUTE D'AFFICHAGE DES PRODUITS
    /**
     * @Route("/admin/", name="admin.index")
     */
    public function index(InstrumentRepository $instrumentRepository):Response
    {

        $produits= $instrumentRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'produits' => $produits
        ]);    }

    
// ROUTE FORMULAIRE
    /**
     * @Route("admin/form", name="admin.form")
     * @Route("/admin/update/{id}", name="admin.update")
     */
    public function form(Request $request, ObjectManager $objectManager, int $id=null, InstrumentRepository $instrumentRepository, StringService $stringService, FileService $fileService):Response
    {
        // préparation des paramètres du formulaire: $entity et $type
        $entity = $id ? $instrumentRepository->find($id) : new Instrument();
        // dd($entity);

        $type = InstrumentType::class;

        // récupération de l'image
        $entity->prevImage = $entity->getImage();
        // dd($entity);      
    
        // création du formulaire
        $form = $this->createForm($type, $entity);
        $form->handleRequest($request);

        // formulaire valide
        if($form->isSubmitted() && $form->isValid()){
        
            // les types dans les getter setters de l'image ont été supprimés dans l'entité Instrument

            // Récupération de l'entité liée au formulaire:

            if(!$entity->getId()){
                // random_bytes: octets binaires aléatoires puis bin2hex pour convertir en hexa

                /*
                UploadedFile: méthodes à utiliser
                    guessExtension(): récupérer l'extension
                    move(): transfert du fichier
                */
                /* avant la création des services
                * $imageName = bin2hex(random_bytes(16));
                * $extension = $uploadedFile->guessExtension();
                * $uploadedFile->move('img/', "$imageName.$extension");
                */
                $imageName = $stringService->generateToken(16);
                $uploadedFile = $entity->getImage();
                $extension = $fileService->getExtension($uploadedFile);
                $fileService->upload($uploadedFile, 'images/', "$imageName.$extension");

                // mise à jour de la propriété image avec le nouveau nom de l'image
                $entity->setImage("$imageName.$extension");
                // dd($entity);
                

                $objectManager->persist($entity);
                $objectManager->flush();
    

            }
            // si l'entité est mise à jour et qu'aucune image n'a été sélectionnée
            elseif($entity->getId() && !$entity->getImage()){
                // récupération de la propriété dynamique prevImage pour remplir la propriété image
                $entity->setImage( $entity->prevImage );
                //dd($entity);


            }

            // si l'entité est mise à jour et qu'une image a été sélectionnée
            elseif($entity->getId() && $entity->getImage()){
                // transfert de la nouvelle image
                $imageName = $stringService->generateToken(16);
                $uploadedFile = $entity->getImage();
                $extension = $fileService->getExtension($uploadedFile);
                $uploadedFile->move('images/', "$imageName.$extension");
                
                //unlink: suppression de l'ancienne image
                unlink("images/{$entity->prevImage}");
                // mise à jour de la propriété image avec le nouveau nom de l'image
                $entity->setImage("$imageName.$extension");
            }

        // dd($entity);

            // mise à jour de la base
        $objectManager->persist($entity);
        $objectManager->flush();

            // redirectToRoute: redirection
            return $this->redirectToRoute('admin.index');   
        }
        return $this->render('admin/form.html.twig', ['form' => $form->createView()]);


    }



    }

