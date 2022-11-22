<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (ProgramFixtures::PROGRAMS as $idx => $program) {
            $program = $this->getReference('program_' . $program['slug']);
            $seasons = $program->getSeasons();
            for ($j = 1; $j <= 5; $j++) {
                for ($i = 1; $i <= 10; $i++) {
                    $episode = new Episode();
                    $episode->setNumber($i);
                    $episode->setTitle($faker->title());
                    $episode->setSynopsis($faker->paragraphs(3, true));
                    $episode->setSeason(
                        $this->getReference(
                            'program_'
                                . str_replace(' ', '', strtolower($program->getTitle()))
                                . '_season_'
                                . $j
                        )
                    );
                    $manager->persist($episode);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
            SeasonFixtures::class,
        ];
    }
}
        // for ($i = 1; $i <= 25; $i++) {
        //     $programOfReference = $this->getReference('program_Title_' . $i);
        //     $numberOfSeasons = count($programOfReference->getSeasons());
        //     for ($j = 1; $j <= $numberOfSeasons; $j++) {
        //         $seasonOfReference = $this->getReference('program_' . $programOfReference->getTitle() . '_S' . $j);
        //         $numberOfEpisodes = rand(10, 20);
        //         $k = 1;
        //         while ($k <= $numberOfEpisodes) {
        //             $episode = new Episode();
        //             $episode->setSeason($seasonOfReference);
        //             $episode->setTitle($faker->sentence($faker->numberBetween(1, 8)));
        //             $episode->setNumber($k);
        //             $episode->setSynopsis($faker->paragraphs(3, true));
        //             $manager->persist($episode);
        //             $k++;