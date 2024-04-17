<?php
// tests/Entity/UserTest.php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Pdf;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetterAndSetter()
    {
        // Création d'une instance de l'entité User
        $user = new User();

        // Définition de données de test
        $email = 'test@test.com';
        $password = 'password123';
        $lastname = 'Doe';
        $firstname = 'John';
        $role = 'ROLE_ADMIN'; // Définissez un rôle approprié ici
        $createdAt = new \DateTimeImmutable();
        $updatedAt = new \DateTimeImmutable();
        // $pdf = new Pdf(); // Si nécessaire, créer une instance de la classe Pdf

        // Utilisation des setters
        $user->setEmail($email)
             ->setPassword($password)
             ->setLastname($lastname)
             ->setFirstname($firstname)
             ->setRole($role)
             ->setCreatedAt($createdAt)
             ->setUpdatedAt($updatedAt);
            //  ->addPdf($pdf); // Si nécessaire, ajouter un objet Pdf

        // Vérification des getters
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($role, $user->getRole());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
        // $this->assertContains($pdf, $user->getPdfs()); // Vérifie la présence de l'objet Pdf dans la collection

        $this->assertEquals($email, $user->getEmail());        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($lastname, $user->getLastname());
        $this->assertEquals($firstname, $user->getFirstname());
        $this->assertEquals($role, $user->getRole());
        $this->assertEquals($createdAt, $user->getCreatedAt());
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
        // $this->assertContains($pdf, $user->getPdfs()); // Vérifie la présence de l'objet Pdf dans la collection
    }
}
