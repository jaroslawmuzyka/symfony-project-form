<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\ProjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectManagerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('methodologies', TextType::class, ['attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Metodologie'], 'required' => false, 'label' => false])
            ->add('reportingSystems', TextType::class, ['attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Systemy Raportujące'], 'required' => false, 'label' => false])
            ->add('scrum', CheckboxType::class, ['attr' => ['class' => 'mt-4'], 'label' => 'Zna Scrum', 'required' => false]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectManager::class,
        ]);
    }
}