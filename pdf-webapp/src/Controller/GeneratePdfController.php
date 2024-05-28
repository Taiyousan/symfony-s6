<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\GeneratePdfType;
use App\Service\PdfGeneratorService;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'app_generate-pdf')]
    public function index(Request $request, PdfGeneratorService $pdfGeneratorService): Response
    {
        $form = $this->createForm(GeneratePdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdfContent = $pdfGeneratorService->generatePdf($form->get('url')->getData());

            $pdfResponse = new Response($pdfContent);
            $pdfResponse->headers->set('Content-Type', 'application/pdf');

            return $pdfResponse;
        }

        $user = $this->getUser();


        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
