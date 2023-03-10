<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UserType;
use App\Repository\UserRepository;
use RegisteringValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $profile = new Profile();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                dump($form->getData());
                dump($_POST);
                dump(strlen($_POST['user']['email']));

            if ($form->getData()->getPassword() == $_POST['user']['passwordConfirm']) {
                $profile
                    ->setFirstName($form->getData()->getProfile()->getFirstName())
                    ->setLastName($form->getData()->getProfile()->getLastName())
                    ->setPhone($form->getData()->getProfile()->getPhone())
                    ->setAdress($form->getData()->getProfile()->getAdress())
                    ->setPostalCode($form->getData()->getProfile()->getPostalCode())
                    ->setCity($form->getData()->getProfile()->getCity());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($profile);
                $entityManager->flush();

                $form->getData()->setPassword($encoder->encodePassword($form->getData(), $form->getData()->getPassword()));
                $user->setProfile($profile);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('login');
            }
            else {
                $this->addFlash('erreur', ' ???  ???Vos mots de passes ne correspondent pas, merci de r??essayer ! ??????');
            }

        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
