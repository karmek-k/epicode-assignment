<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\ApplicantCv;
use App\Form\ApplicantCvUploadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;

class ApplicantCvController extends AbstractController
{
    #[Route('/cv', name: 'app_applicantcv')]
    public function index(): Response
    {
        /** @var Applicant $user */
        $user = $this->getUser();

        return $this->render('applicant_cv/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/cv/download/{cv}', name: 'app_applicantcv_download')]
    public function download(ApplicantCv $cv, DownloadHandler $downloadHandler): Response
    {
        $this->denyAccessUnlessGranted('APPLICANT_CV_HAS_ACCESS', $cv);

        return $downloadHandler->downloadObject($cv, 'file', forceDownload: false);
    }

    #[Route('/cv/upload', name: 'app_applicantcv_upload')]
    public function upload(Request $req, EntityManagerInterface $em): Response
    {
        $cv = new ApplicantCv();
        $form = $this->createForm(ApplicantCvUploadType::class, $cv);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO fix serialization error
            /** @var Applicant $user */
            $user = $this->getUser();
            $user->setCv($cv);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_joboffers');
        }

        return $this->render('applicant_cv/upload.html.twig', [
            'form' => $form,
        ]);
    }
}
