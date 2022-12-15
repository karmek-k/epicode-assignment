<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\JobOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    #[Route('/apply/{offer}', name: 'app_apply')]
    public function index(JobOffer $offer, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('APPLICANT_CV_EXISTS');

        /** @var Applicant $user */
        $user = $this->getUser();

        // TODO maybe check if the user can apply...

        $offer->addApplicant($user);

        $em->persist($offer);
        $em->flush();

        return $this->render('apply/index.html.twig', [
            'offer' => $offer,
        ]);
    }
}
