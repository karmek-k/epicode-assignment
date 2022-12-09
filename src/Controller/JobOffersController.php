<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobOffersController extends AbstractController
{
    #[Route('/', name: 'app_job_offers')]
    public function index(): Response
    {
        return $this->render('job_offers/index.html.twig');
    }
}
