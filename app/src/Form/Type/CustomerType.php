<?php
namespace App\Form\Type;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ])

            ->add('lastname',TextType::class, [
                'attr' => [
                    'class' => 'class-input',
                    'data-custom-error-css-class' => 'class-error-input',
                ],
                'label_attr' => [
                    'class' => 'class-label',
                    'data-custom-error-css-class' => 'class-error-label',
                ]
            ])

            ->add('country',TextType::class, [
                'attr' => [
                    'class' => 'class-input',
                    'data-custom-error-css-class' => 'class-error-input',
                ],
                'label_attr' => [
                    'class' => 'class-label',
                    'data-custom-error-css-class' => 'class-error-label',
                ]
            ])

            ->add('phonenumber',TextType::class, [
                'attr' => [
                    'class' => 'class-input',
                    'data-custom-error-css-class' => 'class-error-input',
                ],
                'label_attr' => [
                    'class' => 'class-label',
                    'data-custom-error-css-class' => 'class-error-label',
                ]
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