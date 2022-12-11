<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobSearchType;
use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobOffersController extends AbstractController
{
    #[Route('/', name: 'app_joboffers')]
    public function list(Request $req, JobOfferRepository $repo): Response
    {
        $form = $this->createForm(JobSearchType::class);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $offers = $repo->findWithListForm($data['maxDaysAgo'], $data['searchQuery']);
        } else {
            $offers = $repo->findAll();
        }

        return $this->render('job_offers/index.html.twig', [
            'form' => $form,
            'offers' => $offers
        ]);
    }

    #[Route('/offer/{offer}', name: 'app_joboffers_view')]
    public function view(JobOffer $offer): Response
    {
        return $this->render('job_offers/view.html.twig', [
            'offer' => $offer,
        ]);
    }
}
