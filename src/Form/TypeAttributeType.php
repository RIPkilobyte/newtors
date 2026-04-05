<?php

namespace App\Form;

use App\Entity\EquipmentAttribute;
use App\Entity\EquipmentType;
use App\Entity\TypeAttribute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('required')
            ->add('sortOrder')
            ->add('type', EntityType::class, [
                'class' => EquipmentType::class,
                'choice_label' => 'id',
            ])
            ->add('attribute', EntityType::class, [
                'class' => EquipmentAttribute::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeAttribute::class,
        ]);
    }
}
