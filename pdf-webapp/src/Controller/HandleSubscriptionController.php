<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;



class HandleSubscriptionController extends AbstractController
{
    #[Route('/handle-subscription', name: 'app_handle_subscription')]
  public function index(EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();
    $currentSubscription = $user->getSubscription();

    $subscriptionRepository = $entityManager->getRepository(Subscription::class);
    $availableSubscriptions = $subscriptionRepository->findAll();

    return $this->render('handle_subscription/index.html.twig', [
        'controller_name' => 'HandleSubscriptionController',
        'user' => $user,
        'currentSubscription' => $currentSubscription,
        'availableSubscriptions' => $availableSubscriptions
    ]);
}

#[Route('/change-subscription/{id}', name: 'app_change_subscription')]
public function changeSubscription(int $id, EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();
    $subscriptionRepository = $entityManager->getRepository(Subscription::class);
    $newSubscription = $subscriptionRepository->find($id);

    if ($newSubscription) {
        $user->setSubscription($newSubscription);
        $entityManager->persist($user);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_handle_subscription');
}
}

