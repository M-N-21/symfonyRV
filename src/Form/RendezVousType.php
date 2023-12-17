<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\TypeRV;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('heure')
//             ->add('Medecin', EntityType::class, [
//                 'class' => Medecin::class,
// 'choice_label' => 'id',
//             ])
//             ->add('patient', EntityType::class, [
//                 'class' => Patient::class,
// 'choice_label' => 'id',
//             ])
            ->add('typeRV', EntityType::class, [
                'class' => TypeRV::class,
                'choice_label' => 'libelle',
                'attr' => [
                    'required' => true,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}