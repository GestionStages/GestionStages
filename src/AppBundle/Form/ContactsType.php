<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomcontact', TextType::class, [
                'disabled' => (!is_null($options['data']->getcodecontact())), //Desactive si on edite le contact
                'required' => true,
                'label' => "Nom (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('prenomcontact',TextType::class, [
                'disabled' => (!is_null($options['data']->getcodecontact())), //Desactive si on edite le contact
                'required' => true,
                'label' => "Prénom (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('userContact', TextType::class, [
                'disabled' => (!is_null($options['data']->getcodecontact())), //Desactive si on edite le contact
                'required' => true,
                'label' => "Nom d'utilisateur (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('mailcontact', EmailType::class, [
                'required' => true,
                'label' => "Adresse email (*)",
                'attr' => ['maxlength' => 1024]
            ])
            ->add('telcontact', TelType::class, [
                'required' => true,
                'label' => "Numéro de téléphone (*)",
                'attr' => ['maxlength' => 10]
            ])
            ->add('postecontact',TextType::class, [
                'required' => true,
                'label' => "Poste dans l'entreprise (*)",
                'attr' => ['maxlength' => 255]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contacts'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contacts';
    }


}
