<?php

namespace App\Form;

use App\Entity\Subscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
          $builder
           /* ->add('quantity', NULL, [
                 'label' => 'Choisissez la quantité de paniers hebdomadaires souhaitées'
              ])
              //->add('frequency')
              // ->add('price')
              //->add('date_start')
              //->add('date_end')
              //->add('paid')
              //->add('bonus')
              // ->add('user')*/
          ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
        ]);
    }
}
