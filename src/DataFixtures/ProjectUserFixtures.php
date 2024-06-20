<?php 
/// src/DataFixtures/ProjectUserFixtures.php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectUserFixture extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        // Récupérer tous les utilisateurs et projets
        $users = $this->manager->getRepository(User::class)->findAll();
        $projects = $this->manager->getRepository(Project::class)->findAll();

        // Associer chaque utilisateur à chaque projet
        foreach ($projects as $project) {
            // Sélectionnez aléatoirement un sous-ensemble d'utilisateurs ou ajustez selon votre logique
            $usersToAdd = array_slice($users, 0, mt_rand(1, count($users)));

            foreach ($usersToAdd as $user) {
                $project->addUser($user);
                $user->addProject($project);

                // Note: Si nécessaire, persistez également les modifications ici
            }
        }

        // Flush pour enregistrer les modifications
        $this->manager->flush();
    }
}
