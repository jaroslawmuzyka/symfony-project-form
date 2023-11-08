<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/', name: 'login')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        /** @var User $user */
        $user = $this->getUser();
        return match ($user->isVerified()) {
            true => $this->render('index.html.twig', [
                'user' => $user,
            ]),
            false => $this->render('please-verify-email.html.twig'),
        };
    }
}