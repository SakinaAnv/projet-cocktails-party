<?php

namespace App\Form;

use App\Entity\Cocktail;
use App\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CocktailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price', MoneyType::class)
            ->add('imagePath',HiddenType::class)
            ->add('photo', FileType::class, [
                'label' => 'Cocktail image ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                            'image/jfif'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],
            ])
            ->add('ingredients', EntityType::class, [
                'expanded' => false,
                'mapped' =>true,
                'required'=>true,
                'class' => Ingredient::class,
                'multiple' => true,
                'attr' => [
                    'class' => 'select2'
                ]
            ])
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
            'data_class' => Cocktail::class,
        ]);
    }
}
