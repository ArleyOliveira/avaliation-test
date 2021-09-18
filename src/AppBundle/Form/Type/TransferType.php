<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PersonUser;
use AppBundle\Entity\Transfer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransferType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('payee', EntityType::class, array(
                'class' => PersonUser::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('pr')
                        ->where('pr.active = :active')
                        ->setParameter('active', true);
                }
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Transfer::class
        ));
    }

    public function getParent(): string
    {
        return TransactionType::class;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }
}