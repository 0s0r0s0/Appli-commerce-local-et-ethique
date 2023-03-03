<?php


namespace App\Controller;


use App\Entity\Good;
use App\Entity\GoodsType;
use App\Entity\LabelledType;
use App\Entity\Producer;
use App\Entity\Profile;
use App\Entity\Trimester;
use App\Entity\UnitType;
use App\Entity\User;
use App\Form\GoodsTType;
use App\Form\LabelledTType;
use App\Form\UnitTType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $producers = $this
            ->getDoctrine()
            ->getRepository(Producer::class)
            ->getNb();

        $goods = $this
            ->getDoctrine()
            ->getRepository(Good::class)
            ->getNb();

        $users = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findAll();


        $meASProd = $this
            ->getDoctrine()
            ->getRepository(Producer::class)
            ->findOneBy(array('user' => $this->getUser()));
        dump($meASProd);

        $myGoods = $this
            ->getDoctrine()
            ->getRepository(Good::class)
            ->findBy(array('producer' => $meASProd));
        dump($myGoods);

        $isUser = $this->getUser();
        if (isset($isUser)) {

            $prodProfile = $this
                ->getDoctrine()
                ->getRepository(Producer::class)
                ->findOneBy(array('user' => $this->getUser()->getId()));
        }else {$prodProfile = 'On en est là';}

        return $this->render('home/index.html.twig', [
            'producers' => $producers,
            'goods' => $goods,
            'users' => $users,
            'prodProfile' => $prodProfile
        ]);
    }

    /**
     * @Route("/charte", name="charte", methods={"GET"})
     * @return Response
     */
    public function showCharte(): Response
    {

        return $this->render('home/charte.html.twig');
    }


    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login( AuthenticationUtils $authenticationUtils ) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("home/login.html.twig", [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/profile", name="profile", methods={"GET"})
     * @return Response
     */
    public function profile()
    {
        $profile = $this
            ->getDoctrine()
            ->getRepository(Profile::class)
            ->find($this->getUser()->getProfile());


        return $this->render("home/profile.html.twig", [
            'profile' => $profile
        ]);
    }

    /**
     * @Route("/nouveau-label", name="good_newLabel", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newLabel(Request $request): Response
    {
        $label = new LabelledType();
        $form = $this->createForm(LabelledTType::class, $label);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($label);
            $entityManager->flush();

            return $this->redirectToRoute('good_new');
        }

        return $this->render('good/newLabel.html.twig', [
            'label' => $label,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nouveau-type-produit", name="good_newProductType", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newProductType(Request $request): Response
    {
        $goodsType = new GoodsType();
        $form = $this->createForm(GoodsTType::class, $goodsType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($goodsType);
            $entityManager->flush();

            return $this->redirectToRoute('good_new');
        }

        return $this->render('good/newProductType.html.twig', [
            'goodsType' => $goodsType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nouvelle-unite", name="good_newUnit", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newUnit(Request $request): Response
    {
        $unit = new UnitType();
        $form = $this->createForm(UnitTType::class, $unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($unit);
            $entityManager->flush();

            return $this->redirectToRoute('good_new');
        }

        return $this->render('good/newUnit.html.twig', [
            'unit' => $unit,
            'form' => $form->createView(),
        ]);
    }




}