<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationClientType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, $this->getConfiguration("Nom", "Votre nom"))
            ->add('prenom', TextType::class, $this->getConfiguration("Prénom", "Votre Prénom"))
            ->add('dateNaissance', DateType::class, $this->getConfiguration("Date de naissance", "Entrez votre date", ["widget" => "single_text"]))
            ->add('adresse', TextType::class, $this->getConfiguration("Adresse", "Votre adresse"))
            ->add('ville', TextType::class, $this->getConfiguration("Ville", "Votre ville"))
            ->add('codePostal', IntegerType::class, $this->getConfiguration("Code Postal", "Entrez votre code postal"))
            ->add('telephone', TelType::class, $this->getConfiguration("Numéro de téléphone", "Entrez votre numéro"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Entrez votre email"))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Entrez votre mot de passe"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
