<?php

namespace App\Form;

use App\Entity\Restaurant;
use App\Entity\Role;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminRegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class, $this->getConfiguration('Nom', 'Nom du restaurant'))
            ->add('adresse', TextType::class, $this->getConfiguration('Adresse', 'Adresse'))
            ->add('ville', TextType::class, $this->getConfiguration('Ville', 'Ville'))
            ->add('codePostal', IntegerType::class, $this->getConfiguration('Code Postal', 'Code Postal'))
            ->add('telephone', TelType::class, $this->getConfiguration('Téléphone', 'Numéro de téléphone'))
            ->add('description', TextareaType::class, $this->getConfiguration('Description', 'Décrire votre restaurant'))
            ->add('email', EmailType::class, $this->getConfiguration('Email', 'Entrez votre email'))
            ->add('hash', PasswordType::class, $this->getConfiguration('Mot de passe', 'Entrez votre mot de passe'))
            ->add('coverImage', TextType::class, $this->getConfiguration('URL', 'Entrez l\'URL de l\'image'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
