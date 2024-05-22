<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Exception;

class PdfGeneratorService
{
    private $client;
    private $parameterBag;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $parameterBag)
    {
        $this->client = $client;
        $this->parameterBag = $parameterBag;
    }

    public function generatePdf(string $url)
    {
        $hostMicroservice = $this->parameterBag->get('PDF_URL');

        $response = $this->client->request('POST', $hostMicroservice . '/converturl', [
            'body' => [
                'url' => $url
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Erreur lors de la génération du PDF.');
        }

        return $response->getContent();
    }
}
