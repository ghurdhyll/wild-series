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
            'title' => 'Walking dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'Horreur',
        ],
        [
            'title' => 'Seigneur des Anneaux',
            'synopsis' => 'Golum was right',
            'category' => 'Aventure',
        ],
        [
            'title' => 'Voyage de chihiro',
            'synopsis' => 'Une petite fille se trouve coincé dans un monde fantastique',
            'category' => 'Fantastique',
        ],
        [
            'title' => 'Princesse mononoke',
            'synopsis' => "l'industrialisation c'est mal",
            'category' => 'Animation',
        ],
        [
            'title' => 'Yacine au tibet',
            'synopsis' => "Yacine n'as plus internet",
            'category' => 'Action',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $nb => $info) {
            foreach ($info as $key => $value) {
            $program = new Program();
            $program->setTitle($info['title']);
            $program->setSynopsis($info['synopsis']);
            $program->setCategory($this->getReference('category_' . $info['category']));
        }
        $manager->persist($program);
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
