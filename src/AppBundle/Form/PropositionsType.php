<?php

namespace AppBundle\Form;

use AppBundle\Controller\TechnologiesController;
use AppBundle\Entity\Technologies;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class PropositionsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$doctrine = $options['doctrine'];

        $builder
            ->add('titreproposition', TextType::class, [
                'required' => true,
                'label' => "Titre (*)",
                'attr' => ['maxlength' => 255]
            ])
            ->add('descriptionproposition',TextareaType::class, [
                'required' => true,
                'label' => "Description (*)"
            ])
            ->add('codeentreprise', EntityType::class, [
                'class'  => 'AppBundle:Entreprises',
	            'choice_label' => 'nomentreprise',
                'placeholder' => 'Sélectionner une entreprise...',
                'required' => true,
                'label' => "Entreprise (*)"
            ])
            ->add('codeclasse',EntityType::class, [
                'class' => 'AppBundle:Classes',
	            'choice_label' => 'nomclasse',
	            'multiple' => true,
	            'expanded' => true,
                'label' => "Classes concernées"
            ])
            ->add('codetechnologie',EntityType::class, [
                'class' => 'AppBundle:Technologies',
	            'choice_label' => 'nomtechnologie',
	            'multiple' => true,
                'label' => "Technologies demandées"
            ])
            ->add('file', FileType::class, [
                'label' => 'Fiche de poste (DOC, DOCX, PDF) (2MB max.)'
            ])
	        ->add('commentaire',TextareaType::class, [
	            'label' => "Commentaire privé"
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use(&$doctrine) {

            	$data = $event->getData();
				$form = $event->getForm();

				if(isset($data['codetechnologie'])) {
					foreach($data['codetechnologie'] as $key => $techno) {

						// Si une des technologies n'existe pas, on la créée
						$match = $doctrine->getRepository(Technologies::class)->findOneBy(['codetechnologie' => $techno]);

						if(empty($match)) {
							$t = new Technologies();
							$t->setNomtechnologie($techno);
							$doctrine->getEntityManager()->persist($t);
							$doctrine->getEntityManager()->flush();

							$data['codetechnologie'][$key] = $t->getCodetechnologie();
						}
						else {
							$data['codetechnologie'][$key] = $match->getCodetechnologie();
						}
					}

					$event->setData($data);
				}
            });
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Propositions'
        ));
        $resolver->setRequired('doctrine');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_propositions';
    }


}
