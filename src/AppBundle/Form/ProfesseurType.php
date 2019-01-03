<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesseurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userProf', TextType::class, [
                'required' => true,
                'disabled' => (!is_null($options['data']->getId())),
                'label' => "Nom d'utilisateur IUT (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('passProf', PasswordType::class, [
                'required' => true,
                'label' => "Mot de passe IUT (*)"
            ])
            ->add('telProf', TelType::class, [
                'required' => true,
                'label' => "Numéro de téléphone (*)",
                'attr' => ['maxlength' => 10]
            ]);

        if (!is_null($options['data']->getId())) {
            $builder
                ->add('nomProf', TextType::class, [
                    'required' => true,
                    'label' => "Nom (*)",
                    'attr' => ['maxlength' => 255]
                ])
                ->add('prenomProf', TextType::class, [
                    'required' => true,
                    'label' => "Prénom (*)",
                    'attr' => ['maxlength' => 255]
                ])
                ->add('mailProf', EmailType::class, [
                    'required' => true,
                    'label' => "Email (*)",
                    'attr' => ['maxlength' => 1024]
                ])
                ->add('confirmPassProf', PasswordType::class, [
                    'required' => true,
                    'label' => "Confirmez le mot de passe (*)",
                    'attr' => ['maxlength' => 255]
                ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Professeur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_professeur';
    }


}
