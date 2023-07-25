<?php

namespace App\DataFixtures;

use App\Entity\Snippet;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un générateur de données Faker en français
        $faker = Factory::create('fr_FR');

        // Création d'un utilisateur de test
        $user = new User();
        $user->setEmail('hello@codexpress.fr')
        ->setUsername('codexpress')
        ->setPassword('$2y$13$4UbZtgjJ2J0JSmY45CZs4uGbUbckq1R.N64JltRbz7JTVpuo3YJzi') // mdp : admin
        ->setRoles(["ROLE_ADMIN"])
        ->setIsVerified(true)
        ;

        // Enregistrement de l'utilisateur en base de données
        $manager->persist($user);

        $snippetContent = '
        <h1>Mon premier snippet</h1>
        <p>Voici mon premier snippet créé avec Cod\'Express !</p>
        <p>Vous pouvez le modifier ou le supprimer depuis votre espace membre.</p>
        <p>Vous pouvez également le partager avec le lien généré.</p>
        ';

        $randomBoolean = [true, false];

        // Boucle pour créer 200 snippets de test
        for ($i=0; $i < 200; $i++) { 
            $snippet = new Snippet();
            $snippet->setTitle($faker->word(2))
            ->setContent($snippetContent)
            ->setUser($user)
            ->setCreatedAt($faker->dateTimeBetween('-7 months'))
            ->setIsPublished($randomBoolean[array_rand($randomBoolean)])
            ->setIsPublic($randomBoolean[array_rand($randomBoolean)])
            ;

            $manager->persist($snippet);
        }

        $manager->flush();
    }
}