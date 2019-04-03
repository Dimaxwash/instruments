<?php

namespace App\Controller;

use App\Repository\InstrumentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/table", name="admin.table")
     */
    public function table(InstrumentRepository $instrumentRepository):Response
    {
        
        $produits= $instrumentRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'produits' => $produits
        ]);
    }
}
