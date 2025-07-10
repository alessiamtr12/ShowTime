<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FestivalFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Search by name or location',
                ],
            ]);
        //            ->add('name')
        //            ->add('price')
        // ->add('location');
        //            ->add('startDate')
        //            ->add('endDate')
        //            ->add('image')
        //            ->add('bands', EntityType::class, [
        //                'class' => Band::class,
        //                'choice_label' => 'id',
        //                'multiple' => true,
        //            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
        ]);
    }
}
