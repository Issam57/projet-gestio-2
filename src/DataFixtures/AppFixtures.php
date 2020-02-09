<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Image;
use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
    $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

       /// Pour gérer les clients
        $clients = [];

        for($i = 1; $i <= 5; $i++) {
            $client = new Client();

            $hash = $this->encoder->encodePassword($client, 'password');

            $client->setNom($faker->lastName)
                    ->setPrenom($faker->firstName)
                    ->setDateNaissance($faker->dateTimeAD)
                    ->setAdresse($faker->address)
                    ->setVille($faker->city)
                    ->setCodePostal(57000)
                    ->setTelephone(0303030303)
                    ->setEmail($faker->email)
                    ->setHash($hash);

            $manager->persist($client);
            $clients[] = $client;
        }

        //Pour gérer les restaurants
        for ($j = 1; $j <= 10; $j++) {

            $resto = new Restaurant();

            $coverImage = $faker->imageUrl(900,350);
            $description = $faker->paragraph(6);
            //$hash = $this->encoder->encodePassword($resto, 'password');

            $resto->setNom($faker->company)
                ->setDescription($description)
                ->setAdresse($faker->address)
                ->setVille($faker->city)
                ->setCodePostal('57000')
                ->setTelephone('0304050607')
                ->setCoverImage($coverImage)
                ->setEmail($faker->email)
                ->setHash('password');


            for ($k = 1; $k <= mt_rand(1, 3); $k++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setResto($resto);

                $manager->persist($image);
            }

             $manager->persist($resto);
        }

        $manager->flush();
    }
}
