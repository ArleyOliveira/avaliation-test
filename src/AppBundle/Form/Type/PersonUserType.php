<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PersonUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PersonUser::class
        ));
    }

    public function getParent(): string
    {
        return UserType::class;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }
}