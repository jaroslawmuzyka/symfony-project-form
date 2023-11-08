<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\ProjectManager;
use App\Entity\Tester;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $testerData = $form->get('tester')->getData();
            $developerData = $form->get('developer')->getData();
            $projectManagerData = $form->get('projectManager')->getData();

            $testerInfo = null;
            $developerInfo = null;
            $projectManagerInfo = null;

            if ($testerData instanceof Tester) {
                $testerInfo .= " Systemy testujące: " . $testerData->getTestingSystems();
                $testerInfo .= " Systemy raportujące: " . $testerData->getReportingSystems();
                $testerInfo .= " Czy użytkownik zna selenium?: " . ($testerData->isSelenium() ? "Tak" : "Nie");
            }

            if ($developerData instanceof Developer) {
                $developerInfo = " Środowiska IDE: " . $developerData->getIde() . "\n";
                $developerInfo .= " Języki programowania: " . $developerData->getProgrammingLanguages();
                $developerInfo .= " Czy użytkownik zna MySQL?: " . ($developerData->isMysql() ? "Tak" : "Nie");
            }

            if ($projectManagerData instanceof ProjectManager) {
                $projectManagerInfo = " Metodologie prowadzenia projektów: " . $projectManagerData->getMethodologies();
                $projectManagerInfo .= " Systemy raportowe: " . $projectManagerData->getReportingSystems();
                $projectManagerInfo .= " Czy użytkownik zna Scrum?: " . ($projectManagerData->isScrum() ? "Tak" : "Nie");
            }

            $generatedPassword = $this->generateRandomPassword();
            $user->setPassword($userPasswordHasher->hashPassword($user, $generatedPassword));
            $entityManager->persist($user);
            $entityManager->flush();


            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('mailer@mailer.com', 'Mailer Bot'))
                    ->to($user->getEmail())
                    ->subject('Potwierdź swój adres email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
                    ->context([
                        'user' => $user,
                        'plainPassword' => $generatedPassword,
                        'testerInfo' => $testerInfo,
                        'developerInfo' => $developerInfo,
                        'projectManagerInfo' => $projectManagerInfo,
                    ])
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Zweryfikowano adres email');

        return $this->redirectToRoute('login');
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