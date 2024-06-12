<?php

namespace App\DataFixtures;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $subscriptionBasic = new Subscription();
        $subscriptionBasic->setTitle('Basique');
        $subscriptionBasic->setPrice(5.00);
        $subscriptionBasic->setDescription('L\'abonnement de départ. Idéal pour tester les fonctionnalités de base de l\'application.');
        $subscriptionBasic->setPdfLimit(3);
        $subscriptionBasic->setMedia('test');

        // $this->subscriptionRepository->save($subscriptionBasic, true);
        $manager->persist($subscriptionBasic);

        $subscriptionStandard = new Subscription();
        $subscriptionStandard->setTitle('Premium');
        $subscriptionStandard->setPrice(10.00);
        $subscriptionStandard->setDescription('L\'abonnement Premium vous permet de créer des PDF de qualité professionnelle. Idéal pour les créateurs de contenu qui souhaitent offrir une expérience de lecture optimale à leur public.');
        $subscriptionStandard->setPdfLimit(10);
        $subscriptionStandard->setMedia('test');

        $manager->persist($subscriptionStandard);

        $subscriptionPremium = new Subscription();
        $subscriptionPremium->setTitle('Platine');
        $subscriptionPremium->setPrice(20.00);
        $subscriptionPremium->setDescription('L\'abonnement Platine est la version la plus complète de notre application. Il vous permet d\'avoir accès à toutes les fonctionnalités disponibles. Idéal pour les professionnels de l\'édition et les entreprises.');
        $subscriptionPremium->setPdfLimit(100);
        $subscriptionPremium->setMedia('test');

        $manager->persist($subscriptionPremium);

        $manager->flush();
    }
}
