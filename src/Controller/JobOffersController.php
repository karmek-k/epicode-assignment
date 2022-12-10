<?php

namespace App\Controller;

use App\Repository\JobOfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobOffersController extends AbstractController
{
    #[Route('/', name: 'app_job_offers')]
    public function list(Request $req, JobOfferRepository $repo): Response
    {
        // TODO clean up
        $maxDaysAgo = $req->query->get('maxDaysAgo');
        $date = null;
        if (!empty($maxDaysAgo)) {
            $maxDaysAgo = (int) $maxDaysAgo;
            $date = new \DateTimeImmutable("now - $maxDaysAgo");
        }

        return $this->render('job_offers/index.html.twig', [
            'offers' => $repo->findNotOlderThan($date),
        ]);
    }
}
