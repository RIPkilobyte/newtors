<?php

namespace App\Form;

use App\Entity\AttributeOption;
use App\Entity\EquipmentAttribute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttributeOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value')
            ->add('label')
            ->add('sortOrder')
            ->add('attribute', EntityType::class, [
                'class' => EquipmentAttribute::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AttributeOption::class,
        ]);
    }
}
