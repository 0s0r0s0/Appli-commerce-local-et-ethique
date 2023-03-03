<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', null, [
                'required' => true,
                'label' => 'Prénom'
            ])
            ->add('last_name', null, [
                'required' => true,
                'label' => 'Nom'
            ])
            ->add('phone', null, [
                'required' => true,
                'label' => 'Téléphone'
             ])
            ->add('adress', null, [
                 'required' => true,
                 'label' => 'Adresse'
             ])
            ->add('postal_code', null, [
                 'required' => true,
                 'label' => 'Code postal'
             ])
            ->add('city', null, [
                  'required' => true,
                  'label' => 'Ville'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
