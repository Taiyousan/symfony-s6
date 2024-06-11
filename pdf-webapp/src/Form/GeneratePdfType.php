<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GeneratePdfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'label' => 'URL',
                'attr' => [
                    'placeholder' => 'https://www.example.com',
                ],
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Convertir la page en PDF',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'formtarget' => '_blank',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
