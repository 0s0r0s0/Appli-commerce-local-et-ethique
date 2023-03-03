<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\TradeArea;
use App\Entity\User;
use App\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $pattern = '%ER';
        $builder
            ->add('profile', ProfileType::class)
            ->add('email')
            ->add('password', NULL , [
                'label' => 'Mot de passe'
            ])
            ->add('passwordConfirm', NULL, [
                'label' => 'Confirmez votre mot de passe',
                'mapped' => false,
                'required' => true
            ])
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'required' => true,
                'label' => 'Rôle',
                'choice_label' => function ($role) {
                    return $role->getOwnLabel();
                    },
                'expanded' => true,
                'multiple' => false,
                'query_builder' => function(RoleRepository $repository)
            use($pattern) {
                return $repository->getLikeQueryBuilder($pattern);
                }

            ])
            ->add('trade_area', EntityType::class, [
                'class' => TradeArea::class,
                'required' => true,
                'label' => 'Votre secteur',
                'choice_label' => 'label',
                'multiple' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
