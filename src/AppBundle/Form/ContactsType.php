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
        // si on edit le contact
        if ($options['data']->getcodecontact() != null){
            $builder
                ->add('nomcontact', TextType::class, array('disabled' => true))
                ->add('prenomcontact',TextType::class, array('disabled' => true))
                ->add('mailcontact', EmailType::class, )
                ->add('telcontact', TelType::class)
                ->add('postecontact',TextType::class);
        }
        //si on ajoute un contact
        else
        {
            $builder
                ->add('nomcontact', TextType::class)
                ->add('prenomcontact',TextType::class)
                ->add('mailcontact', EmailType::class )
                ->add('telcontact', TelType::class)
                ->add('postecontact',TextType::class);
        }

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
