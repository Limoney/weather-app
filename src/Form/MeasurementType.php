<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Entity\WeatherCondition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('temperatureCelsius')
            ->add('location', EntityType::class,[
                'class' => Location::class,
                'choice_label' => 'city'
            ])
            ->add('weatherCondition',EntityType::class,[
                'class' => WeatherCondition::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
