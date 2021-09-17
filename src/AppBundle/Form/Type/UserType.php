<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => array(
                    new NotNull(["message" => "Informe o campo e-mail!"]),
                    new Email(["message" => "Este e-mail não é válido!"])
                ),
            ])
            ->add('plainPassword', RepeatedType::class,
                array(
                    'first_options' => array(),
                    'second_options' => array(),
                    'type' => PasswordType::class,
                    'constraints' => array(
                        new NotNull(["message" => "Informe os campos de senha!"]),
                    ),
                    'invalid_message' => 'Os campos de senha, não são iguais!'
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return '';
    }
}