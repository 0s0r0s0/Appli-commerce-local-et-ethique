<?php

namespace App\Controller;

use App\Entity\LabelledType;
use App\Entity\Producer;
use App\Entity\User;
use App\Form\LabelledTType;
use App\Form\ProducerType;
use App\Repository\ProducerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producer")
 */
class ProducerController extends AbstractController
{
    /**
     * @Route("/", name="producer_index", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $producers = $paginator->paginate(
            $this
                ->getDoctrine()
                ->getRepository( Producer::class)
                ->findAll(),
            $request
                ->query->getInt('page', 1),
            8

        );

        return $this->render('producer/index.html.twig', [
            'producers' => $producers,
        ]);
    }

    /**
     * @Route("/mes-producteurs", name="producer_showMyProducers", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function showMyProducers(PaginatorInterface $paginator, Request $request): Response
    {

        $myProducers = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('trade_area' => $this->getUser()->getTradeArea()->getId()));

        $producers = $paginator->paginate(
            $producers = $this
            ->getDoctrine()
            ->getRepository(Producer::class)
            ->findBy(array('user' => $myProducers)),

            $request
                ->query->getInt('page', 1),
            8

        );

        return $this->render('producer/myProducer.html.twig', [
            'producers' => $producers,
        ]);
    }

    /**
     * @Route("/new", name="producer_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $producer = new Producer();
        $user = $this->getUser();
        $form = $this->createForm(ProducerType::class, $producer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $producer->setUser($user);

            $entityManager->persist($producer);
            $entityManager->flush();

            return $this->redirectToRoute('producer_index');
        }

        return $this->render('producer/new.html.twig', [
            'producer' => $producer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producer_show", methods={"GET"})
     */
    public function show(Producer $producer): Response
    {
        return $this->render('producer/show.html.twig', [
            'producer' => $producer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="producer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Producer $producer): Response
    {
        $form = $this->createForm(ProducerType::class, $producer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producer_index');
        }

        return $this->render('producer/edit.html.twig', [
            'producer' => $producer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Producer $producer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producer_index');
    }

}
