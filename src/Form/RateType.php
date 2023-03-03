<?php

namespace App\Form;

use App\Entity\Rate;
use App\Entity\UnitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('unitType', EntityType::class, [
               'class' => UnitType::class,
               'choice_label' => 'label',
               'label' => 'unité, kg, litre etc...',
               'required' => true,
                'multiple' => false
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rate::class,
        ]);
    }
}
