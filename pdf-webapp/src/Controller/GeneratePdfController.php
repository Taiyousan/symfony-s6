<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\GeneratePdfType;
use App\Service\PdfGeneratorService;
use App\Entity\Pdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Repository\PdfRepository;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'app_generate-pdf')]
    public function index(Request $request, PdfGeneratorService $pdfGeneratorService, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        $pdfRepository = $entityManager->getRepository(Pdf::class);
        // check la limite journalière
         // Définir les dates de début et de fin pour la recherche
         $startOfDay = new \DateTime('today');
         $endOfDay = new \DateTime('tomorrow');

         $pdfCount = $pdfRepository->countPdfGeneratedByUserOnDate($user->getId(), $startOfDay, $endOfDay);

         $conversionLeft = $user->getSubscription()->getPdfLimit() - $pdfCount;

         ;

       if ($conversionLeft > 0) {
        $form = $this->createForm(GeneratePdfType::class);
        $form->handleRequest($request);
       } else {
        $form = null;
       }

       if ($form !== null && $form->isSubmitted() && $form->isValid()) {
        $url = $form->get('url')->getData();
            $pdfContent = $pdfGeneratorService->generatePdf($url);

            // Sauvegarder le contenu du PDF dans un fichier
            $filesystem = new Filesystem();
            $pdfDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/pdf';
            $title = parse_url($url, PHP_URL_HOST);
            $filename = $title . uniqid() . '.pdf';
            $filePath = $pdfDirectory . '/' . $filename;

            if (!$filesystem->exists($pdfDirectory)) {
                $filesystem->mkdir($pdfDirectory, 0700);
            }

            $filesystem->dumpFile($filePath, $pdfContent);

            // Enregistrer l'entité Pdf
            $pdf = new Pdf();
            $pdf->setPath('/uploads/pdf/' . $filename);
            $pdf->setUrl($url);
            $pdf->setTitle($title);
            $pdf->setCreatedAt(new \DateTimeImmutable());
            $pdf->setOwner($this->getUser());

            $entityManager->persist($pdf);
            $entityManager->flush();

            // Générer la réponse PDF
            $pdfResponse = new Response($pdfContent);
            $pdfResponse->headers->set('Content-Type', 'application/pdf');

            return $pdfResponse;
        }


        $dataToRender = [
            'user' => $user,
            'conversionLeft' => $conversionLeft
        ];
        
        if ($form !== null) {
            $dataToRender['form'] = $form->createView();
        }
        
        return $this->render('generate_pdf/index.html.twig', $dataToRender);
        
    }
}
