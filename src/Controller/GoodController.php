<?php

namespace App\Controller;

use App\Entity\Good;
use App\Entity\GoodsType;
use App\Entity\LabelledType;
use App\Entity\Producer;
use App\Entity\ProductionType;
use App\Entity\Rate;
use App\Entity\UnitType;
use App\Form\GoodType;
use App\Form\LabelledTType;
use App\Repository\GoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/good")
 */
class GoodController extends AbstractController
{
    /**
     * @Route("/", name="good_index", methods={"GET"})
     */
    public function index(GoodRepository $goodRepository): Response
    {
        return $this->render('good/index.html.twig', [
            'goods' => $goodRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="good_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $good = new Good();
        
        // Requête de récupération du producteur connecté via son user_id
        $producer = $this
            ->getDoctrine()
            ->getRepository(Producer::class)
            ->findOneBy(array('user' => $this->getUser()->getId()));

        // Création du formulaire
        $form = $this->createForm(GoodType::class, $good);
        $form->handleRequest($request);

        // Validation du formulaire
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $good->setProducer($producer);
            $entityManager->persist($good);
            $entityManager->flush();

            return $this->redirectToRoute('good_index');
        }

        return $this->render('good/new.html.twig', [
            'good' => $good,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="good_show", methods={"GET"})
     */
    public function show(Good $good): Response
    {
        return $this->render('good/show.html.twig', [
            'good' => $good,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="good_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Good $good
     * @return Response
     */
    public function edit(Request $request, Good $good): Response
    {
        $form = $this->createForm(GoodType::class, $good);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('good_index');
        }

        return $this->render('good/edit.html.twig', [
            'good' => $good,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="good_delete", methods={"DELETE"})
     * @param Request $request
     * @param Good $good
     * @return Response
     */
    public function delete(Request $request, Good $good): Response
    {
        if ($this->isCsrfTokenValid('delete'.$good->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($good);
            $entityManager->flush();
        }

        return $this->redirectToRoute('good_index');
    }

}
