<?php
/**
 * Created by PhpStorm.
 * User: axelc
 * Date: 29/01/2019
 * Time: 08:28
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactInscriptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mailcontact', EmailType::class, [
                'required' => true,
                'disabled' => true,
                'label' => "Addresse email (*)",
                'attr' => ['maxlength' => 1024]
            ])
            ->add('mdpcontact', PasswordType::class, [
                'required' => true,
                'label' => "Mot de passe",
                'attr' => ['minlength' => 8]
            ]);
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contacts',
            'validation_groups' => ['inscription']
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