<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Config\FosCkEditorConfig;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' =>'Votre e-mail',
                'attr' => [
                    'class' => 'container row row-cols-2 form-control'
                ]
            ])
            ->add('nickname', TextType::class, [
                'label' =>'Votre pseudo',
                'attr' => [
                    'class' => 'col-md-6 form-control'
                ]
            ])
            ->add('content', TextType::class, [
                'label' =>'Votre commentaire',
                'attr' => [
                    'class' => 'container col-2 form-control'
                ]
            ])

            ->add('product', HiddenType::class, [
                'mapped' => false
            ])
            ->add('parentid', HiddenType::class, [
                'mapped' => false
            ])
            ->add('send', SubmitType::class, [
                'label' =>'Envoyer',
                'attr' => [
                    'class' => 'mt-3 btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
