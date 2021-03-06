<?php

namespace AppBundle\Form;


use AppBundle\Entity\GroupesLdap;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class ClassesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomclasse', TextType::class, [
                'required' => true,
                'label' => "Nom (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => "Description (*)",
                'attr' => ['maxlength' => 1024]
            ])
            ->add('dateDebStage', DateType::class, [
                'label' => "Date début stage",
                'widget' => 'single_text'
            ])
            ->add('dateFinStage', DateType::class, [
                'label' => "Date fin stage",
                'widget' => 'single_text'
            ])
            ->add('codegroupeldap', EntityType::class, [
                'required' => true,
                'label' => "Section sur l'annuaire LDAP (*)",
                'placeholder' => "Sélectionnez une section...",
                'class' => 'AppBundle\Entity\GroupesLdap',
                'choice_label' => 'ldapSection'
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Classes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_classes';
    }


}
