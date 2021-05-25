<?php

namespace App\Form;

use App\Entity\ShoppingList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoppingListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('owner')
            ->add('category')
            ->add('shoppingListItems', CollectionType::class, [
                'entry_type' => ShoppingListItemType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'attr' => ['class' => 'collection'],
                'entry_options' => ['label' => false]
            ])
            ->add('price', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShoppingList::class,
        ]);
    }
}
