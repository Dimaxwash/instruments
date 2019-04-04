<?php

namespace App\Controller;

use App\Entity\Instrument;
use App\Form\InstrumentType;
use App\Service\FileService;
use App\Service\StringService;
use App\Repository\InstrumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InstrumentController extends AbstractController
{
// ROUTE D'AFFICHAGE DES INSTRUMENTS
    /**
     * @Route("/instruments", name="instruments.table")
     */
    public function table(InstrumentRepository $instrumentRepository):Response
    {

        $produits= $instrumentRepository->findAll();
        return $this->render('instrument/instruments.html.twig', [
            'produits' => $produits
        ]);
    }
// ROUTE DETAILS INSTRUMENT
    /**
     * @Route("/instrument/{id}", name="instrument.details")
     */
    public function details(int $id, InstrumentRepository $instrumentRepository):Response
    {
        $result=$instrumentRepository->find($id);
        return $this->render('instrument/details.html.twig', ['result' => $result]);
    }

    
    /**
     * @Route("/", name="home.index")
     */
    public function index():Response
    {
        return $this->render('instrument/index.html.twig');
    }
}

