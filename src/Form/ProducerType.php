<?php

namespace App\Form;

use App\Entity\Producer;
use App\Entity\ProductionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProducerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siret')
            ->add('firm_name')
            ->add('firm_adress')
            ->add('firm_postal_code')
            ->add('firm_city')
            ->add('description')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
            ])
            ->add('phone_number')
            ->add('production_type', EntityType::class, [
                'class' => ProductionType::class,
                'required' => true,
                'label' => 'Votre type de production principal',
                'choice_label' => 'label',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producer::class,
        ]);
    }
}
