<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        [
            'slug' => 'walkingdead',
            'title' => 'Walking dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'Action',
        ],
        [
            'slug' => 'seigneurdesanneaux',
            'title' => 'Seigneur des Anneaux',
            'synopsis' => 'Golum was right',
            'category' => 'Aventure',
        ],
        [
            'slug' => 'voyagedechihiro',
            'title' => 'Voyage de chihiro',
            'synopsis' => 'Une petite fille se trouve coincé dans un monde fantastique',
            'category' => 'Fantastique',
        ],
        [
            'slug' => 'princessemononoke',
            'title' => 'Princesse mononoke',
            'synopsis' => "l'industrialisation c'est mal",
            'category' => 'Animation',
        ],
        [
            'slug' => 'yacine.localhost',
            'title' => 'Yacine.localhost',
            'synopsis' => "Yacine n'as plus internet",
            'category' => 'Horreur',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $programInfo) {
            $program = new Program();
            $program->setTitle($programInfo['title']);
            $program->setSynopsis($programInfo['synopsis']);
            $program->setCategory($this->getReference('category_' . $programInfo['category']));
            $manager->persist($program);
            $this->addReference('program_' . $programInfo['slug'], $program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
