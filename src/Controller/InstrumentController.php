<?php

namespace App\Controller;

use App\Repository\InstrumentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InstrumentController extends AbstractController
{
    /**
     * @Route("/instruments", name="instruments.table")
     */
    public function table(InstrumentRepository $instrumentRepository):Response
    {
        
        $produits= $instrumentRepository->findAll();

        return $this->render('instrument/produits.html.twig', [
            'produits' => $produits
        ]);
    }

   /**
    * @Route("/", name="index.homepage")
    */ 
    public function homepage():Response

    {
        return $this->render('instrument/index.html.twig');
    }
}

