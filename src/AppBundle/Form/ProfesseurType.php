<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
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
