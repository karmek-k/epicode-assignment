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
        $this->denyAccessUnlessGranted(
            'JOB_OFFER_USER_CAN_APPLY',
            $offer,
            'You have already applied there'
        );
        $this->denyAccessUnlessGranted('APPLICANT_CV_EXISTS', message: 'Please upload a CV');

        /** @var Applicant $user */
        $user = $this->getUser();

        $offer->addApplicant($user);

        $em->persist($offer);
        $em->flush();

        return $this->render('apply/index.html.twig', [
            'offer' => $offer,
        ]);
    }
}
