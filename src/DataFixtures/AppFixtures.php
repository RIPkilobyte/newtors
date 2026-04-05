<?php

namespace App\DataFixtures;

use App\Entity\AttributeOption;
use App\Entity\EquipmentAttribute;
use App\Entity\EquipmentType;
use App\Entity\TypeAttribute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $equipmentTypePC = new EquipmentType();
        $equipmentTypePC->setName('ПК');
        $manager->persist($equipmentTypePC);

        $equipmentAttributeProc = new EquipmentAttribute();
        $equipmentAttributeProc->setName('processor');
        $equipmentAttributeProc->setLabel('Процессор');
        $equipmentAttributeProc->setDataType('select');
        $equipmentAttributeProc->setIsMultiple(false);
        $manager->persist($equipmentAttributeProc);

        $link = new TypeAttribute();
        $link->setType($equipmentTypePC);
        $link->setAttribute($equipmentAttributeProc);
        $manager->persist($link);

        $opt1 = new AttributeOption();
        $opt1->setAttribute($equipmentAttributeProc);
        $opt1->setValue('Intel i5');
        $opt1->setLabel('Intel Core i5');
        $manager->persist($opt1);

        $manager->flush();
    }
}
