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

class GeneratePdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'app_generate-pdf')]
    public function index(Request $request, PdfGeneratorService $pdfGeneratorService, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GeneratePdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        $user = $this->getUser();

        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
