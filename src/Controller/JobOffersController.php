<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\JobSearchType;
use App\Repository\JobOfferRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobOffersController extends AbstractController
{
    #[Route('/', name: 'app_joboffers')]
    public function list(Request $req, JobOfferRepository $repo, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(JobSearchType::class);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $offersQuery = $repo->findWithListFormQuery($data['maxDaysAgo'], $data['searchQuery']);
        } else {
            $offersQuery = $repo->findAllQuery();
        }

        $page = $req->query->getInt('page', 1);
        $pagination = $paginator->paginate($offersQuery, $page, 6);

        return $this->render('job_offers/index.html.twig', [
            'form' => $form,
            'pagination' => $pagination,
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
