<?php

// src/Form/NameFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, ['label' => 'First Name',])
            ->add('nom', TextType::class, ['label' => 'Last Name',])
            ->add('username', TextType::class, ['label' => 'Username',])
            ->add('motdepasse', PasswordType::class, ['label' => 'Password',]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Utilisateur',
        ]);
    }

    

}
