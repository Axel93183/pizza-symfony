<?php

namespace App\Form;

use App\Entity\Pizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
        ->add('name', TextType::class, [
            'label'=>'Nom de la pizza: ',
            'required'=> true
        ])
        ->add('price', MoneyType::class, [
            'label'=>'Prix de la pizza: ',
            'required'=> true
        ])
        ->add('description', TextareaType::class, [
            'label'=>'Composition de la pizza: ',
            'required'=> true
        ])
        ->add('imageUrl', UrlType::class, [
            'label'=>'Image de la pizza: ',
            'required'=> true
        ])
        ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
        ]);
    }
}
