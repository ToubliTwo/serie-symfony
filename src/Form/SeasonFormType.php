<?php

namespace App\Form;

use App\Entity\Season;
use App\Entity\Serie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('firstAirDate', null, [
                'widget' => 'single_text',
            ])
            ->add('overview')
            ->add('poster')
            ->add('tmdbId')
            ->add('dateCreated', null, [
                'widget' => 'single_text',
            ])
            ->add('dateModified', null, [
                'widget' => 'single_text',
            ])
            ->add('serie', EntityType::class, [
                'class' => Serie::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
