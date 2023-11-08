<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\ProjectManager;
use App\Entity\Tester;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{
    private EntityManagerInterface $em;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/create', name: 'create_user')]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();

            $generatedPassword = $this->generateRandomPassword();
            $newUser->setPassword($userPasswordHasher->hashPassword($newUser, $generatedPassword));

            $this->em->persist($newUser);
            $this->em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/create.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }

    #[Route('/admin/edit/{id}', name: 'edit_user')]
    public function edit($id, Request $request): Response
    {
        $user = $this->userRepository->find($id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/edit.html.twig', [
            'user' => $user,
            'registrationForm' => $form->createView()
        ]);
    }

    #[Route('/admin/delete/{id}', name: 'delete_user', methods: ['GET', 'DELETE'])]
    public function delete($id): Response
    {
        $user = $this->userRepository->find($id);
        $this->em->remove($user);
        $this->em->flush();

        return $this->redirectToRoute('admin');
    }

    #[Route('/admin/{id}', name: 'show_user', methods: ['GET'])]
    public function show($id): Response
    {
        $user = $this->userRepository->find($id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        return $this->render('admin/edit.html.twig', [
            'user' => $user,
            'registrationForm' => $form->createView(),
        ]);
    }

    private function generateRandomPassword($length = 12): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-={}[]|:;"<>,.?/';
        $password = null;
        $charactersLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $charactersLength - 1)];
        }

        return $password;
    }
}