<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class)
            ->add('roles', ChoiceType::class, [
                'expanded' => true,
                'required'=>true,
                'multiple' => false,
                'mapped' =>false,
                'choices'  => [
                    'Client' => "ROLE_CLIENT",
                    'Personnel' => "ROLE_STAFF",
                    'Administrateur' => "ROLE_ADMIN",
                ]
            ])
            ->add('password',PasswordType::class)
            ->add('name')
            ->add('firstname')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('submit', SubmitType::class)
            ->add('reset', ResetType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
