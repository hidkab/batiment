<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                "label" => "Nom de la tâche",
                "attr" => ["class" => "form-control m-2 border-dark w-25 m-auto"]
            ])
            ->add('description', null, [
                "label" => "Description de la tâche",
                "attr" => ["class" => "form-control m-2 border-dark w-25 m-auto"]
            ])
            ->add('createDate', null, [
                "label" => "Date de création",
                "attr" => ["class" => "m-2"]
            ])
            ->add('deadline', null, [
                "label" => "Date limite",
                "attr" => ["class" => "m-2"]
            ])
            ->add('status', null, [
                "label" => "Statut",
                "attr" => ["class" => "m-2"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
