<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la voiture :  ',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('nbSeats', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nombre de sièges :  ',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('nbDoors', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nombre de Sièges :',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('cost', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prix de la voiture : ',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'btn btn-primary mt-4'
            ],
            'label' => 'Valider'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
