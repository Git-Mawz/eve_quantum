<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Category;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'placeholder' => 'Choissez une catégorie',
                'required' => true,
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'Sujet',
                'required' => true,

            ])
            // ->add('content', TextareaType::class, [
            //     'label' => 'Question'
            // ])
            ->add('content', CKEditorType::class, [
                'label' => 'Question',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il semblerait qu\'il manque votre question.'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
            'label' => 'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
