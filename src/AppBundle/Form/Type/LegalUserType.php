<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\LegalUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegalUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cnpj', TextType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => LegalUser::class
        ));
    }

    public function getParent(): string
    {
        return PersonUserType::class;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }
}