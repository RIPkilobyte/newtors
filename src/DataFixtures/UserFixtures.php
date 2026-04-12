<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Raion;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function getDependencies(): array
    {
        return [
            RaionFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $raion41 = $this->getReference(RaionFixtures::RAION41, Raion::class);

        $admin = new User();
        $admin->setEmail('admin@ripkilobyte.ru');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $editor = new User();
        $editor->setEmail('editor@ripkilobyte.ru');
        $editor->setPassword($this->passwordHasher->hashPassword($editor, 'editor'));
        $editor->setRoles(['ROLE_EDITOR']);
        $manager->persist($editor);

        $viewer = new User();
        $viewer->setEmail('viewer@ripkilobyte.ru');
        $viewer->setPassword($this->passwordHasher->hashPassword($viewer, 'viewer'));
        $viewer->setRoles(['ROLE_VIEWER']);
        $manager->persist($viewer);

        $raion41Admin = new User();
        $raion41Admin->setEmail('admin41@ripkilobyte.ru');
        $raion41Admin->setPassword($this->passwordHasher->hashPassword($raion41Admin, 'admin41'));
        $raion41Admin->setRoles(['ROLE_RAION_ADMIN']);
        $raion41Admin->setRaion($raion41);
        $manager->persist($raion41Admin);

        $raion41Viewer = new User();
        $raion41Viewer->setEmail('viewer41@ripkilobyte.ru');
        $raion41Viewer->setPassword($this->passwordHasher->hashPassword($raion41Viewer, 'viewer41'));
        $raion41Viewer->setRoles(['ROLE_RAION_VIEWER']);
        $raion41Viewer->setRaion($raion41);
        $manager->persist($raion41Viewer);

        $manager->flush();
    }
}
