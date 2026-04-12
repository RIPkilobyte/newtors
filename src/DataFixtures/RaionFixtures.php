<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Raion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaionFixtures extends Fixture
{
    public const RAION00 = '073000';
    public const RAION41 = '073041';

    public function load(ObjectManager $manager): void
    {
        $raion00 = new Raion();
        $raion00->setName("ОПФР");
        $raion00->setCode('073000');
        $manager->persist($raion00);

        $raion41 = new Raion();
        $raion41->setName("КОФ");
        $raion41->setCode('073041');
        $manager->persist($raion41);

        $manager->flush();

        $this->addReference(self::RAION00, $raion00);
        $this->addReference(self::RAION41, $raion41);
    }
}
