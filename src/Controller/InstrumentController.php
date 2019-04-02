<?php

namespace App\Controller;

use App\Repository\InstrumentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InstrumentController extends AbstractController
{
    /**
     * @Route("/instruments", name="instrument.index")
     */
    public function index(InstrumentRepository $instrumentRepository):Response
    {
        
        $produits= $instrumentRepository->findAll();
        return $this->render('instrument/index.html.twig', [
            'produits' => $produits
        ]);
    }
}
