<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Subscription;
use App\Entity\Trimester;
use App\Form\SubscriptionType;
use App\Repository\AssociationRepository;
use App\Repository\BasketRepository;
use App\Repository\FactureRepository;
use App\Repository\SubscriptionRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subscription")
 */
class SubscriptionController extends AbstractController
{
    /**
     * @Route("/", name="subscription_index", methods={"GET"})
     */
    public function index(SubscriptionRepository $subscriptionRepository): Response
    {
        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="subscription_new", methods={"GET","POST"})
     */
    public function new(Request $request, FactureRepository $factureRepository, BasketRepository $basketRepository): Response
    {
        // On récupère le trimestre actuel sous forme [label, date_start, date_end ]
        $myTrimester = $this
            ->getDoctrine()
            ->getRepository(Trimester::class)
            ->FindOneByActualDate();

        $date = new DateTime();
        $date->format('Y-m-d');
        $dateEnd = $myTrimester->getDateEnd();


        // On compte le nombre de panier restant pour ce trimestre (entre date souscription et fin trimestre)
        $daysLeft = date_diff($date, $dateEnd);
        $nbPanierLeft = floor($daysLeft->days/7);

        $subscription = new Subscription();
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // En fonction de la quantité de paniers commandés on calcule le prix
            if ($_POST['quantity']  )$quantity = $_POST['quantity'];
            $priceHT = $quantity * $nbPanierLeft * 10;
            $taxe = $priceHT * 0.05;
            $priceTTC = $priceHT + $taxe;

            $subscription->setUser($this->getUser());
            $subscription->setDateStart($date);
            $subscription->setDateEnd($dateEnd);
            $subscription->setQuantity($quantity);
            $subscription->setPrice($priceHT);
            $subscription->setTax($taxe);
            $subscription->setPriceWithTax($priceTTC);
            $subscription->setPaid(0);
            $subscription->setBonus(0);
            $entityManager->persist($subscription);
            $entityManager->flush();

            // TODO createFacture(); -->SetUser doit être l'asso val llech, profile à créer
            //  Reference doit etre la ref unique issue du calcul countBy + 000 devant en fonction du résultat
            // Vérifier enregistrement facture BDD -> calcul HT foiré

            // On attribue l'identifiant unique de la facture en fonction du nombre de factures du jour
            $nbOfDailyBills = $factureRepository->countByDay() + 1;
            $uniqueRef = '';

            switch (strlen($nbOfDailyBills)) {
                case 1: $uniqueRef = '000' . $nbOfDailyBills;
                    break;
                case 2: $uniqueRef = '00' . $nbOfDailyBills;
                    break;
                case 3: $uniqueRef = '0' . $nbOfDailyBills;
                    break;
                case 4: $uniqueRef = $nbOfDailyBills;
                    break;
            }

            $refFacture = $date->format('Y-m-d') . '-' . $uniqueRef  ;

            $facture = new Facture();
            $em = $this->getDoctrine()->getManager();
            $facture->setUser($this->getUser())
                ->setCustomer($this->getUser())
                ->setDescription('Panier de légumes - Val Llech')
                ->setQuantity($quantity)
                ->setReference($refFacture)
                ->setDate($date)
                ->setPriceHT(round($priceHT / (1+(5.5/100)), 2, PHP_ROUND_HALF_EVEN))
                ->setTVA(5.5)
                ->setDeliveryTax($taxe)
                ->setPriceTTC($priceTTC)
                ->setSubId($subscription);

            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('subscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscription/new.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView(),
            'trimester' => $myTrimester,
            'paniers' => $nbPanierLeft,
            'tarif' => $basketRepository->find(1)
        ]);
    }

    /**
     * @Route("/mes-commandes", name="subscription_myorders", methods={"GET"})
     */
    public function showMyOrders(SubscriptionRepository $subscriptionRepository): Response
    {

        return $this->render('subscription/myOrders.html.twig', [
            'subscriptions' => $subscriptionRepository->findBy(
                array('user' => $this->getUser()),
                array('date_start' => 'DESC')
            ),
        ]);
    }

    /**
     * @Route("/{id}", name="subscription_show", methods={"GET"})
     */
    //TODO changer ligne facture prix total HT
    public function show($id, Subscription $subscription, FactureRepository $factureRepository, BasketRepository $basketRepository, AssociationRepository $associationRepository): Response
    {dump($factureRepository->findBy(array('sub_id' => $id)));
        return $this->render('subscription/show.html.twig', [
            'subscription' => $subscription,
            'facture' => $factureRepository->findOneBy(array('sub_id' => $id)),
            'panier' => $basketRepository->find(1),
            'asso' => $associationRepository->find(1)
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscription_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Subscription $subscription): Response
    {
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscription/edit.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscription_delete", methods={"POST"})
     */
    public function delete(Request $request, Subscription $subscription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscription->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subscription_index', [], Response::HTTP_SEE_OTHER);
    }



}
