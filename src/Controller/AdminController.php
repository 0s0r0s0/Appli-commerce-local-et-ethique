<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
 class AdminController extends AbstractController
{
     /**
      * @Route ("/", name="controle_paiements", methods={"GET","POST"})
      */
    public function validatePaiment():Response
    {
        return $this->render('facture/index.html.twig', [

        ]);
    }

     /**
      * @Route ("/statistiques", name="stats", methods={"GET"})
      * @return Response
      */
    public function showStats(UserRepository $userRepository):Response
    {
        try {
            return $this->render('admin/stats.html.twig', [
                'user' => $userRepository->countUsers()
            ]);
        } catch (NoResultException | NonUniqueResultException $e) {
        }
    }
}