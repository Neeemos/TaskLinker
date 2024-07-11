<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $isEdit = $options['is_edit'];
        $builder
            ->setMethod('POST')
            ->add('title', TextType::class, [
                'label' => 'Titre de la tâche',
                'empty_data' => ''

            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'empty_data' => ''
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => "date",
                'empty_data' => null,
                'invalid_message' => 'Veuillez entrer une date valide.',
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
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'title',
                'attr' => ['style' => 'display:none;'], // Hide the field
                'label' => false,
            ])

            ->add('submit', SubmitType::class, [
                'label' => $isEdit ? 'Modifier' : 'Ajouter',
                'attr' => ['class' => 'button button-submit']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'status' => '1',
            'is_edit' => false,
        ]);
        $resolver->setRequired('project');
        $resolver->setAllowedTypes('project', [Project::class]);
    }
}
