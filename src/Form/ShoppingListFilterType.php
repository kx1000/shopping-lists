<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class ShoppingListFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromAt', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('toAt', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'required' => false,
            ])
        ;
    }
}
