<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\GeneratePdfType;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GeneratePdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'app_generate_pdf')]
    public function index(Request $request, HttpClientInterface $client, ParameterBagInterface $parameterBag): Response
    {
        $form = $this->createForm(GeneratePdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Appel vers le micro service
            $hostMicroservice = $parameterBag->get('PDF_URL');

            $response = $client->request('POST', $hostMicroservice . '/converturl', [
                'body' => [
                    'url' => $form->get('url')->getData()
                ]
            ]);

            // Vérifiez si le statut de la réponse est 200 OK
            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Erreur lors de la génération du PDF.');
            }

            $pdfContent = $response->getContent();

            $pdfResponse = new Response($pdfContent);
            $pdfResponse->headers->set('Content-Type', 'application/pdf');

            return $pdfResponse;
        }

        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
