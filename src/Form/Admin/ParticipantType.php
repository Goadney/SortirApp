<?php

namespace App\Form\Admin;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //form builder
        $builder
            ->add('pseudo', TextType::class, [
                'required' => true,
                'label' => 'Pseudo',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre pseudo']
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre nom']
            ])
            ->add('prenom', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre prénom']
            ])
            ->add('telephone', TelType::class, [
                'required' => false,
                'label' => 'Numéro de téléphone',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre numéro de téléphone']
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'label' => 'Campus',
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre numéro de téléphone']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
