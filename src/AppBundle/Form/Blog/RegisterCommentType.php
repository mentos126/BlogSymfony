<?php

namespace AppBundle\Form\Blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Blog\RegisterComment;
use Doctrine\DBAL\Types\StringType;


class RegisterCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', null /*StringType::class*/, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher',
                    'class' => 'form-control',
                ]
            ])
        ;        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Blog\RegisterComment',
            'method' => 'get',
            //'csrf_protection' => false,
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}