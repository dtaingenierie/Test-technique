<?php
namespace App\Form\Type;

use App\Entity\Customer;
use App\Entity\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\Locales;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class, [
                'attr' => [
                    'class' => 'class-input',
                    'data-custom-error-css-class' => 'class-error-input',
                ],
                'label_attr' => [
                    'class' => 'class-label',
                    'data-custom-error-css-class' => 'class-error-label',
                ],
                'label' => 'First name',
            ])

            ->add('lastname',TextType::class, [
                'attr' => [
                    'class' => 'class-input',
                    'data-custom-error-css-class' => 'class-error-input',
                ],
                'label_attr' => [
                    'class' => 'class-label',
                    'data-custom-error-css-class' => 'class-error-label',
                ],
                'label' => 'Last name'
            ])

            ->add('country',ChoiceType::class, [
                'placeholder' => 'Select country',
                'choices' => [
                    Countries::getCountries()
                ],
                'attr' => [
                    'class' => 'class-input',
                    'data-custom-error-css-class' => 'class-error-input',
                ],
                'label' => 'Country'
            ])

            ->add('phonenumber',TextType::class, [
                'attr' => [
                    'class' => 'class-input',
                    'data-custom-error-css-class' => 'class-error-input',
                ],
                'label_attr' => [
                    'class' => 'class-label',
                    'data-custom-error-css-class' => 'class-error-label',
                ],
                'label' => 'Phone number'
            ])

            ->add('callme', SubmitType::class, [
                'label' => 'Call me',
                'attr' => [
                    'class' => 'class-button',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}