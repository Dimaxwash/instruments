<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Instrument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class InstrumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /*
            contraintes du champ image:
                si l'entité possède un id vide: ajouter la contrainte NotBlank
                si l'entité possède un id: supprimer la contrainte NotBlank

                options['data']: accès à l'entité
        */
        $entity = $options['data'];
        $constraintsImage = [
            new Image([
            'mimeTypes' => [ 'image/jpeg', 'image/gif', 'image/png', 'image/svg+xml', 'image/webp' ],
                    'mimeTypesMessage' => "Formats d'image acceptés: jpeg, gif, png, webp."
                ])

            ];

            // ajputer la contrainte NotBlank uniquement si l'id est vide
        if(!$entity->getId()){
            array_push($constraintsImage, new NotBlank([
                'message' => 'Veuillez sélectionner une image'
            ]));
        }
            
        $builder
        ->add('name', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => "Veuillez renseigner ce champ."
                ]),
                new Length([
                    'min' => 2,
                    'max' => 150,
                    'minMessage' => "Le nom de l'instrument doit comporter {{ limit }} caractères minimum.",
                    'maxMessage' => "Le nom de l'instrument doit comporter au maximum {{ limit }} caractères."
                ])
            ]
        ])
        ->add('price', MoneyType::class, [
            'currency' => 'EUR',
            'constraints' => [
                new NotBlank([
                    'message' => "Veuillez indiquer un prix."
                ]),
                new GreaterThanOrEqual([
                    'value' => 0,
                    'message' => "Le prix ne peut pas être négatif."
                    ])
            ]
        ])
        ->add('description')
        ->add('image', FileType::class, [
                'constraints' => $constraintsImage,
                'help' => 'Veuillez sélectionner une image au format JPG, GIF, PNG, SVG ou WebP',
                'data_class' => null
            ])
            // champ catégorie: liste déroulante
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Instrument::class,
        ]);
    }
}
