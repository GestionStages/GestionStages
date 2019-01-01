<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userEtudiant', TextType::class, [
                'required' => true,
                'label' => "Nom d'utilisateur IUT (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('passEtudiant', PasswordType::class, [
                'required' => true,
                'label' => "Mot de passe IUT (*)"
            ])
            ->add('numEtudiant', TextType::class, [
                'required' => true,
                'label' => "Numéro étudiant (*)",
                'attr' => ['maxlength' => 8]
            ])
            ->add('telEtudiant', TelType::class, [
                'required' => true,
                'label' => "Numéro de téléphone (*)",
                'attr' => ['maxlength' => 10]
            ])
            ->add('addrEtudiant', TextType::class, [
                'required' => true,
                'label' => "Addresse fixe (*)",
                'attr' => ['maxlength' => 1024]
            ])
            ->add('dateEtudiant', DateType::class, [
                'required' => true,
                'label' => "Date de naissance (*)",
                'widget' => 'single_text'
            ])
            ->add('sexeEtudiant', ChoiceType::class, [
                'required' => true,
                'label' => "Sexe (*)",
                'choices' => [
                    'Homme' => 'h',
                    'Femme' => 'f',
                    'N/A' => 'o'
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('codeclasse', EntityType::class, array(
                'required' => true,
                'label' => "Classe (*)",
                'class' => 'AppBundle:Classes',
                'choice_label' => 'nomclasse',
                'placeholder' => "Sélectionnez votre classe..."
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Etudiant'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_etudiant';
    }


}
