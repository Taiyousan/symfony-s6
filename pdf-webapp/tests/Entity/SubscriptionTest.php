<?php
// tests/Entity/SubscriptionTest.php

namespace App\Tests\Entity;

use App\Entity\Subscription;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité Subscription
        $subscription = new Subscription();

        // Définition de données de test
        $title = 'Subscription Title';
        $description = 'Subscription Description';
        $pdfLimit = '10'; // Limite de PDFs
        $price = '9.99'; // Prix
        $media = 'Online'; // Média de la souscription
        $user = new User(); // Création d'un utilisateur lié à la souscription

        // Utilisation des setters
        $subscription->setTitle($title)
                     ->setDescription($description)
                     ->setPdfLimit($pdfLimit)
                     ->setPrice($price)
                     ->setMedia($media)
                     ->addUser($user); // Ajout d'un utilisateur à la souscription

        // Vérification des getters
        $this->assertEquals($title, $subscription->getTitle());
        $this->assertEquals($description, $subscription->getDescription());
        $this->assertEquals($pdfLimit, $subscription->getPdfLimit());
        $this->assertEquals($price, $subscription->getPrice());
        $this->assertEquals($media, $subscription->getMedia());
        $this->assertContains($user, $subscription->getUsers()); // Vérifie la présence de l'utilisateur dans la collection des utilisateurs

        // Vérification de la relation bidirectionnelle avec l'utilisateur
        $this->assertSame($subscription, $user->getSubscription()); // Vérifie que la souscription de l'utilisateur est bien la souscription actuelle
    }
}
