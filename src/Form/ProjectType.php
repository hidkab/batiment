<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                "label" => "Nom du projet",
                "attr" => ["class" => "form-control m-2 border-dark w-25 m-auto"]
            ])
            ->add('description', null, [
                "label" => "Description du projet",
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
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
