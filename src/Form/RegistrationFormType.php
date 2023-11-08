<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('description', TextareaType::class, ['attr' => ['required' => false]])
            ->add('jobPosition', ChoiceType::class, [
                'choices' => [
                    'Wybierz stanowisko' => null,
                    'Tester' => 'tester',
                    'Developer' => 'developer',
                    'Project Manager' => 'project_manager',
                ],
                'required' => false,
            ])
            ->add('tester', TesterFormType::class, [
                'required' => false,
            ])
            ->add('developer', DeveloperFormType::class, [
                'required' => false,
            ])
            ->add('projectManager', ProjectManagerFormType::class, [
                'required' => false,
            ])
            ->add('Zarejestruj', SubmitType::class, ['attr' => ['class' => 'btn btn-primary mt-3']]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}