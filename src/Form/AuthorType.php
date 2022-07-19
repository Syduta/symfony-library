<?php

namespace App\Form;

use App\Entity\Author;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('birthDate',\Symfony\Component\Form\Extension\Core\Type\DateType::class,[
                'widget'=>'choice',
                'years'=>range(date('Y'),date('Y')-300)
            ])
            ->add('deathDate',\Symfony\Component\Form\Extension\Core\Type\DateType::class,[
                'widget'=>'choice',
                'years'=>range(date('Y'),date('Y')-300)
            ])
            ->add('image',FileType::class,['mapped'=>false])
            ->add('picture')
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
