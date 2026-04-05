<?php

namespace App\Form;

use App\Entity\EquipmentAttribute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('label')
            ->add('dataType')
            ->add('isMultiple')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EquipmentAttribute::class,
        ]);
    }
}
