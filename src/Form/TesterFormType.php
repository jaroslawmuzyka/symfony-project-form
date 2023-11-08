<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Tester;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TesterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('testingSystems', TextType::class, ['attr' => ['class' => 'form-control mt-3', 'placeholder' => 'Wpisz systemy testujące'], 'required' => false, 'label' => false])
            ->add('reportingSystems', TextType::class, ['attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Wpisz systemy raportujące'], 'required' => false, 'label' => false])
            ->add('selenium', CheckboxType::class, ['attr' => ['class' => 'my-4'], 'label' => 'Zna Selenium', 'required' => false]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tester::class,
        ]);
    }
}