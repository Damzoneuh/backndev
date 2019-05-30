<?php

namespace App\Form;

use App\Entity\Benefits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BenefitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'validate'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'validate'
                ]
            ])
            ->add('price', TextType::class, [
                'attr' => [
                    'class' => 'validate'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'submit'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Benefits::class,
        ]);
    }
}
