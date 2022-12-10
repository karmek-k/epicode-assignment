<?php

namespace App\Controller;

use App\Entity\JobOffer;
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
        // TODO clean up
        $maxDaysAgo = $req->query->get('maxDaysAgo');
        $date = null;
        if (!empty($maxDaysAgo) && !str_starts_with($maxDaysAgo, '-')) {
            $maxDaysAgo = (int) $maxDaysAgo;
            $date = new \DateTimeImmutable("now - $maxDaysAgo days");
        }

        return $this->render('job_offers/index.html.twig', [
            'offers' => $repo->findNotOlderThan($date),
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
