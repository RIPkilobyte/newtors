<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Equipment;
use App\Entity\Raion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('inventory')
            ->add('serial')
            ->add('attributes')
            ->add('raion', EntityType::class, [
                'class' => Raion::class,
                'choice_label' => 'name',
            ])
            ->add('type', EntityType::class, [
                'class' => \App\Entity\EquipmentType::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
