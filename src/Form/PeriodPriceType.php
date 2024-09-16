<?php

namespace App\Form;

use App\Entity\PeriodPrice;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_period', null, [
                'widget' => 'single_text',
            ])
            ->add('endPeriod', null, [
                'widget' => 'single_text',
            ])
            ->add('price_day')
            ->add('properties', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PeriodPrice::class,
        ]);
    }
}
