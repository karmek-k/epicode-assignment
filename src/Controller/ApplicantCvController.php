<?php

namespace App\Controller;

use App\Entity\Applicant;
use App\Entity\ApplicantCv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/cv/{cv}', name: 'app_applicantcv_download')]
    public function download(ApplicantCv $cv, DownloadHandler $downloadHandler): Response
    {
        $this->denyAccessUnlessGranted('APPLICANT_CV_HAS_ACCESS', $cv);

        return $downloadHandler->downloadObject($cv, 'file', forceDownload: false);
    }
}
