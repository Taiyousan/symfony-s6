<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;


class ConvertUrl extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/converturl', name: 'app_convert_url')]
    public function index(Request $request): Response
    {

        $url = ['url' => $request->request->get('url')];


        // Envoyer la requête à Gotenberg pour convertir HTML en PDF
        $response = $this->httpClient->request('POST', 'http://localhost:3000/forms/chromium/convert/url', 
        [
            'headers' => [
                'Content-Type'=>'multipart/form-data'
            ],
            'body' => $url
        ]);

        // Vérifier si la requête a réussi
        if ($response->getStatusCode() === 200) {
            // Récupérer le contenu de la réponse
            $pdfContent = $response->getContent();
            
            // Traiter le contenu du PDF si nécessaire
            
            // Retourner une réponse JSON avec le contenu du PDF
            return new Response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="file.pdf"',
            ]);
        } else {
            // En cas d'échec de la requête, retourner une réponse d'erreur
            return $this->json([
                'error' => 'Failed to convert HTML to PDF',
            ], $response->getStatusCode());
        }
    }
}
