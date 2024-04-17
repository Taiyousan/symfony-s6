<?php
// tests/Entity/PdfTest.php

namespace App\Tests\Entity;

use App\Entity\Pdf;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité Pdf
        $pdf = new Pdf();

        // Définition de données de test
        $title = 'PDF Title';
        $createdAt = new \DateTimeImmutable();
        $user = new User(); // Création d'un utilisateur propriétaire du PDF

        // Utilisation des setters
        $pdf->setTitle($title)
            ->setCreatedAt($createdAt)
            ->setOwner($user); // Définition de l'utilisateur propriétaire du PDF

        // Vérification des getters
        $this->assertEquals($title, $pdf->getTitle());
        $this->assertEquals($createdAt, $pdf->getCreatedAt());
        $this->assertSame($user, $pdf->getOwner()); // Vérifie que l'utilisateur propriétaire est le même que celui défini

        // Vérification de la relation bidirectionnelle avec l'utilisateur
        $this->assertTrue($user->getPdfs()->contains($pdf)); // Vérifie que la collection des PDFs de l'utilisateur contient le PDF actuel
        $this->assertSame($user, $pdf->getOwner()); // Vérifie que l'utilisateur propriétaire du PDF est bien l'utilisateur actuel
    }
}
