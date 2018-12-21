<?php

namespace AppBundle\Form\Blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Blog\PostSearch;
use Doctrine\DBAL\Types\StringType;


class PostSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('partTitle', null, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Search',
                    'class' => 'form-control',
                ]
            ])
        ;        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Blog\PostSearch',
            'method' => 'get',
            'csrf_protection' => false,
            'translation_domain' => 'forms'
        ));
    }

    public function getBlockPrefix()
    {
        return '';
    }
}