<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceFieldName;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('surname', TextType::class, ['label' => 'Prénom'])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('status', TextType::class, [
                'label' => 'Statut',
                'constraints' => [
                    new Choice([
                        'choices' => ['CDI', 'CDD'],
                        'message' => 'Le statut doit être soit "CDI" soit "CDD".',
                    ]),
                ],
            ])
                ->add('date', null, [
                    'widget' => 'single_text',
                    'label' => "date d'entrée",
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Enregistrer',
                    'attr' => ['class' => 'button button-submit']
                ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
