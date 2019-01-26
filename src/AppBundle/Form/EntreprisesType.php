<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreprisesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomentreprise', TextType::class, [
                'required' => true,
                'label' => "Nom (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('adresseentreprise', TextType::class, [
                'required' => true,
                'label' => "Adresse (*)",
                'attr' => ['maxlength' => 1024]
            ])
            ->add('villeentreprise', TextType::class, [
                'required' => true,
                'label' => "Ville (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('codepostalentreprise', TextType::class, [
                'required' => true,
                'label' => "Code postal (*)",
                'attr' => ['maxlength' => 5]
            ])
            ->add('telentreprise',TelType::class, [
                'required' => true,
                'label' => "Téléphone (*)",
                'attr' => ['maxlength' => 10]
            ])
            ->add('codedomaine',EntityType::class, [
                'class' => 'AppBundle:Domaineactivite',
                'choice_label' => 'nomdomaine',
                'multiple' => true,
                'expanded' => true,
                'label' => "Domaines d'activité"
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Entreprises'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_entreprises';
    }


}
