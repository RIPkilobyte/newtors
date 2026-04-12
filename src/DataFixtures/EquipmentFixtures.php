<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\EquipmentAttribute;
use App\Entity\EquipmentAttributeOption;
use App\Entity\EquipmentType;
use App\Entity\EquipmentTypeAttribute;
use App\Entity\Raion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EquipmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            RaionFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        /** @var Raion $raion00 */
        $raion00 = $this->getReference(RaionFixtures::RAION00, Raion::class);
        /** @var Raion $raion41 */
        $raion41 = $this->getReference(RaionFixtures::RAION41, Raion::class);

        // EquipmentType
        $pcType = new EquipmentType();
        $pcType->setName('ПК');
        $manager->persist($pcType);

        $monitorType = new EquipmentType();
        $monitorType->setName('Монитор');
        $manager->persist($monitorType);

        $printerType = new EquipmentType();
        $printerType->setName('Принтер');
        $manager->persist($printerType);

        // EquipmentAttribute
        $cpuAttr = new EquipmentAttribute();
        $cpuAttr->setName('processor');
        $cpuAttr->setLabel('Процессор');
        $cpuAttr->setDataType('select');
        $cpuAttr->setIsMultiple(false);
        $manager->persist($cpuAttr);

        $ramAttr = new EquipmentAttribute();
        $ramAttr->setName('ram_gb');
        $ramAttr->setLabel('ОЗУ (ГБ)');
        $ramAttr->setDataType('integer');
        $ramAttr->setIsMultiple(false);
        $manager->persist($ramAttr);

        $hddAttr = new EquipmentAttribute();
        $hddAttr->setName('hdd');
        $hddAttr->setLabel('Винчестер');
        $hddAttr->setDataType('string');
        $hddAttr->setIsMultiple(true);
        $manager->persist($hddAttr);

        $diagonalAttr = new EquipmentAttribute();
        $diagonalAttr->setName('diagonal_inch');
        $diagonalAttr->setLabel('Диагональ (дюймы)');
        $diagonalAttr->setDataType('float');
        $diagonalAttr->setIsMultiple(false);
        $manager->persist($diagonalAttr);

        $printFormatAttr = new EquipmentAttribute();
        $printFormatAttr->setName('print_format');
        $printFormatAttr->setLabel('Формат печати');
        $printFormatAttr->setDataType('select');
        $printFormatAttr->setIsMultiple(false);
        $manager->persist($printFormatAttr);

        // EquipmentAttributeOption
        $cpuOptions = ['Intel i5', 'Intel i7', 'AMD Ryzen 5'];
        foreach ($cpuOptions as $opt) {
            $option = new EquipmentAttributeOption();
            $option->setAttribute($cpuAttr);
            $option->setValue($opt);
            $option->setLabel($opt);
            $option->setSort(0);
            $manager->persist($option);
        }

        $printOptions = ['A4', 'A3', 'A2'];
        foreach ($printOptions as $opt) {
            $option = new EquipmentAttributeOption();
            $option->setAttribute($printFormatAttr);
            $option->setValue($opt);
            $option->setLabel($opt);
            $option->setSort(0);
            $manager->persist($option);
        }

        // EquipmentTypeAttribute
        $typeAttribute = new EquipmentTypeAttribute();
        $typeAttribute->setType($pcType);
        $typeAttribute->setAttribute($cpuAttr);
        $typeAttribute->setRequired(true);
        $typeAttribute->setSort(0);
        $manager->persist($typeAttribute);

        $typeAttribute2 = new EquipmentTypeAttribute();
        $typeAttribute2->setType($pcType);
        $typeAttribute2->setAttribute($ramAttr);
        $typeAttribute2->setRequired(true);
        $typeAttribute2->setSort(0);
        $manager->persist($typeAttribute2);

        $typeAttribute3 = new EquipmentTypeAttribute();
        $typeAttribute3->setType($pcType);
        $typeAttribute3->setAttribute($hddAttr);
        $typeAttribute3->setRequired(false);
        $typeAttribute3->setSort(0);
        $manager->persist($typeAttribute3);

        $typeAttribute4 = new EquipmentTypeAttribute();
        $typeAttribute4->setType($monitorType);
        $typeAttribute4->setAttribute($diagonalAttr);
        $typeAttribute4->setRequired(true);
        $typeAttribute4->setSort(0);
        $manager->persist($typeAttribute4);

        $typeAttribute5 = new EquipmentTypeAttribute();
        $typeAttribute5->setType($printerType);
        $typeAttribute5->setAttribute($printFormatAttr);
        $typeAttribute5->setRequired(true);
        $typeAttribute5->setSort(0);
        $manager->persist($typeAttribute5);

        $equipment1 = new Equipment();
        $equipment1->setInventory('PC-001');
        $equipment1->setSerial('123456789');
        $equipment1->setType($pcType);
        $equipment1->setRaion($raion00);
        $equipment1->setAttributes([
            'processor' => 'Intel i7',
            'ram_gb' => 16,
            'hdd' => ['500GB SSD', '1TB HDD']
        ]);
        $manager->persist($equipment1);

        $equipment2 = new Equipment();
        $equipment2->setInventory('MON-001');
        $equipment2->setSerial('9876543241');
        $equipment2->setType($monitorType);
        $equipment2->setRaion($raion41);
        $equipment2->setAttributes(['diagonal_inch' => 24.5]);
        $manager->persist($equipment2);

        $manager->flush();
    }
}
