<?php

namespace App\DataFixtures;

use App\Entity\JobOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; ++$i) {
            $offer = new JobOffer();
            $offer->setJobName($this->randomJobName());
            $offer->setDescription('Lorem ipsum dolor sit amet');
            $offer->setCreationDate(new \DateTimeImmutable());

            $manager->persist($offer);
        }

        $manager->flush();
    }

    private function randomJobName(): string
    {
        $seniority = ['Trainee', 'Junior', 'Regular', 'Senior', 'Lead'];
        $tech = ['Node.js', 'PHP', 'Java', 'Frontend', '.NET'];

        $randomSeniority = $seniority[array_rand($seniority)];
        $randomTech = $tech[array_rand($tech)];

        return "$randomSeniority $randomTech Developer";
    }
}
