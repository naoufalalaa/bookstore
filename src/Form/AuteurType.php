<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_prenom', TextType::class,[
                'label'=> false,
                'attr'=>[
                    'class' => 'uk-input',
                    'placeholder' => 'Entrez le nom et le prénom de l\'auteur '
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'label'=> false,
                'choices'  => [
                    'Male' => 'M',
                    'Female' => 'F',
                ], 
                'attr'=>[
                    'class' => 'uk-select',
                ]
            ])
            ->add('date_de_naissance',BirthdayType::class,[
                'label'=> false,
                'attr'=>[
                    'class' => 'uk-input',
                ],
                'widget' => 'single_text',
            ])
            ->add('nationalite', CountryType::class,[
                'label'=> false,
                'attr'=>[
                    'class' => 'uk-select',
                ]
            ] )
            //->add('livres')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
