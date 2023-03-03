<?php

namespace App\Service\RegisteringValidation;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RegisteringValidation extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegisteringValidation::class);
    }

    public function validateEmail($email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validatePassword($password, $passwordConfirm): string
    {
        $message = '';
        if ($password == $passwordConfirm) {
            if (strlen($password) <= 3 ){
                $message = '⛔ Veuillez saisir un mot de passe comprenant + de 3 caractères ⛔ ';
            }
            elseif (strlen($password) >= 18){
                $message = '⛔ Veuillez saisir un mot de passe comprenant - de 18 caractères ⛔ ';
            }
        }
        else {
            $message = '⛔  ️Vos mots de passes ne correspondent pas, merci de réessayer ! ⛔';
        }
        return $message;
    }

   /* private function validateName($name)
    {
        if ($name )
    }*/
}