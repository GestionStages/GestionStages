<?php

namespace AppBundle\Form;

use AppBundle\Entity\Entreprises;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropositionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreproposition', TextType::class)
            ->add('descriptionproposition',TextareaType::class)
            ->add('codeentreprise', EntityType::class, array(
                'class'  => 'AppBundle:Entreprises',
	            'choice_label' => 'nomentreprise',
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('e')->where('e.blacklister=0');
                },
                'placeholder' => 'Sélectionner une entreprise...'
	            ))
            ->add('codeclasse',EntityType::class, array(
                'class' => 'AppBundle:Classes',
	            'choice_label' => 'nomclasse',
	            'multiple' => true,
	            'expanded' => true,
                ))
            ->add('codetechnologie',EntityType::class, array(
                'class' => 'AppBundle:Technologies',
	            'choice_label' => 'nomtechnologie',
	            'multiple' => true,
	            'expanded' => true,
            ))
            ->add('file', FileType::class, array('label' => 'Fiche de poste (DOC, DOCX, PDF)'))
	        ->add('commentaire',TextareaType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Propositions'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_propositions';
    }


}
