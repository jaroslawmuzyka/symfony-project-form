<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Developer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeveloperFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ide', TextType::class, ['attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Środowiska Ide'], 'required' => false, 'label' => false])
            ->add('programmingLanguages', TextType::class, ['attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Języki programowania'], 'required' => false, 'label' => false])
            ->add('mysql', CheckboxType::class, ['attr' => ['class' => 'my-4'], 'label' => 'Zna Mysql ', 'required' => false]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developer::class,
        ]);
    }
}