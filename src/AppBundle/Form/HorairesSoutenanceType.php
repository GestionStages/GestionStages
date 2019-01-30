<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorairesSoutenanceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('planning_startdate', DateType::class, [
                'required' => true,
                'label' => "Date de début des soutenances (*)",
                'widget' => 'single_text'
            ])
            ->add('planning_enddate', DateType::class, [
                'required' => true,
                'label' => "Date de fin des soutenances (*)",
                'widget' => 'single_text'
            ])
            ->add('planning_starthourAm', TimeType::class, [
                'required' => true,
                'label' => "Heure de début des soutenances (Matin) (*)",
                'widget' => 'single_text'
            ])
            ->add('planning_endhourAm', TimeType::class, [
                'required' => true,
                'label' => "Heure de fin des soutenances (Matin) (*)",
                'widget' => 'single_text'
            ])
            ->add('planning_starthourPm', TimeType::class, [
                'required' => true,
                'label' => "Heure de début des soutenances (Après-midi) (*)",
                'widget' => 'single_text'
            ])
            ->add('planning_endhourPm', TimeType::class, [
                'required' => true,
                'label' => "Heure de fin des soutenances (Après-midi) (*)",
                'widget' => 'single_text'
            ])
            ->add('planning_timeinterval', IntegerType::class, [
                'required' => true,
                'label' => "Durée d'un créneau de soutenance (*)",
                'attr' => ['maxlength' => 255]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Properties',
            'validation_groups' => ['horaires_soutenance']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_properties';
    }


}
