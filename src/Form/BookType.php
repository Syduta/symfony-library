<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('pages')
            ->add('publishedAt',\Symfony\Component\Form\Extension\Core\Type\DateType::class,[
                'widget'=>'choice',
                'years'=>range(date('Y'),date('Y')-300)
            ])
            ->add('author',EntityType::class,[
                'class'=>Author::class,
                'choice_label'=>'lastName',
                'placeholder'=>'Liste d\'auteurs',
            ])

            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
