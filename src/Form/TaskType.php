<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $project = $options['project'];
        $status = $options['status'];
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la tâche',
                'constraints' => array(
                    new NotBlank([
                        'message' => 'test'
                    ])
                )
            ])
            ->add('description')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'To do' => '1',
                    'Doing' => '2',
                    'Done' => '3',
                ],
                'data' => $status,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'label' => 'Membre'
            ])
            ->add('project', HiddenType::class, [
                'mapped' => false, // We will manually map it in the controller
            ])
            ->add('projectEntity', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'title',
                'attr' => ['style' => 'display:none;'], // Hide the field
                'mapped' => false, // We will manually map it in the controller
                'label' => false,
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'button button-submit']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'status' => '1',
        ]);
        $resolver->setRequired('project');
        $resolver->setAllowedTypes('project', [Project::class, 'null']);
    }
}
