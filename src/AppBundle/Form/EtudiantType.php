<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('numEtudiant', TextType::class)
            ->add('telEtudiant', TelType::class)
            ->add('addrEtudiant', TextType::class)
            ->add('dateEtudiant', DateType::class, ['widget' => 'single_text'])
            ->add('sexeEtudiant', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'h',
                    'Femme' => 'f',
                    'N/A' => 'o'
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('codeclasse', EntityType::class, array(
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
