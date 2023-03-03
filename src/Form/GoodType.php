<?php

namespace App\Form;

use App\Entity\Good;
use App\Entity\GoodsType;
use App\Entity\LabelledType;
use App\Entity\Rate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('buying_minimum')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_label' => '...',
                'download_uri' => true,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('stock')
            ->add('label')
            ->add('goods_type', EntityType::class, [
                'class' => GoodsType::class,
                'choice_label' => 'label',
                'label' => 'Quel est le type de ce produit?',
                'required' => true,
                'multiple' => false
            ])
            ->add('rate', RateType::class)

            ->add('labelled_type', EntityType::class, [
                'class' => LabelledType::class,
                'choice_label' => 'label',
                'label' => "Si votre produit dispose d'un label, choisissez le:",
                'required' => false,
                'expanded' => true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Good::class,
        ]);
    }
}
