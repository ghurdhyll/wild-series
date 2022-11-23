<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 10; $i++) {
            $actor = new Actor();
            $actor->setName($faker->Name());
            foreach (ProgramFixtures::PROGRAMS as $program) {
                $number = $faker->numberBetween(0, 1);
                if ($number === 1) {
                    $actor->addProgram($this->getReference('program_' . $program['slug']));
                }
            }
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
