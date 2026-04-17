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

        $laptopType = new EquipmentType();
        $laptopType->setName('Ноутбук');
        $manager->persist($laptopType);

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

        $batteryAttr = new EquipmentAttribute();
        $batteryAttr->setName('battery_life');
        $batteryAttr->setLabel('Время работы (часы)');
        $batteryAttr->setDataType('float');
        $batteryAttr->setIsMultiple(false);
        $manager->persist($batteryAttr);

        // EquipmentAttributeOption
        $cpuOptions = ['Intel i5', 'Intel i7', 'AMD Ryzen 5', 'AMD Ryzen 7'];
        foreach ($cpuOptions as $opt) {
            $option = new EquipmentAttributeOption();
            $option->setEquipmentAttribute($cpuAttr);
            $option->setValue($opt);
            $option->setLabel($opt);
            $option->setSort(0);
            $manager->persist($option);
        }

        $printOptions = ['A4', 'A3', 'A2'];
        foreach ($printOptions as $opt) {
            $option = new EquipmentAttributeOption();
            $option->setEquipmentAttribute($printFormatAttr);
            $option->setValue($opt);
            $option->setLabel($opt);
            $option->setSort(0);
            $manager->persist($option);
        }

        // EquipmentTypeAttribute
        $typeAttr = new EquipmentTypeAttribute();
        $typeAttr->setEquipmentType($pcType);
        $typeAttr->setEquipmentAttribute($cpuAttr);
        $typeAttr->setRequired(true);
        $typeAttr->setSort(0);
        $manager->persist($typeAttr);

        $typeAttr2 = new EquipmentTypeAttribute();
        $typeAttr2->setEquipmentType($pcType);
        $typeAttr2->setEquipmentAttribute($ramAttr);
        $typeAttr2->setRequired(true);
        $typeAttr2->setSort(0);
        $manager->persist($typeAttr2);

        $typeAttr3 = new EquipmentTypeAttribute();
        $typeAttr3->setEquipmentType($pcType);
        $typeAttr3->setEquipmentAttribute($hddAttr);
        $typeAttr3->setRequired(false);
        $typeAttr3->setSort(0);
        $manager->persist($typeAttr3);

        $typeAttr4 = new EquipmentTypeAttribute();
        $typeAttr4->setEquipmentType($monitorType);
        $typeAttr4->setEquipmentAttribute($diagonalAttr);
        $typeAttr4->setRequired(true);
        $typeAttr4->setSort(0);
        $manager->persist($typeAttr4);

        $typeAttr5 = new EquipmentTypeAttribute();
        $typeAttr5->setEquipmentType($printerType);
        $typeAttr5->setEquipmentAttribute($printFormatAttr);
        $typeAttr5->setRequired(true);
        $typeAttr5->setSort(0);
        $manager->persist($typeAttr5);

        $typeAttr6 = new EquipmentTypeAttribute();
        $typeAttr6->setEquipmentType($laptopType);
        $typeAttr6->setEquipmentAttribute($cpuAttr);
        $typeAttr6->setRequired(true);
        $typeAttr6->setSort(0);
        $manager->persist($typeAttr6);

        $typeAttr7 = new EquipmentTypeAttribute();
        $typeAttr7->setEquipmentType($laptopType);
        $typeAttr7->setEquipmentAttribute($ramAttr);
        $typeAttr7->setRequired(true);
        $typeAttr7->setSort(0);
        $manager->persist($typeAttr7);

        $typeAttr8 = new EquipmentTypeAttribute();
        $typeAttr8->setEquipmentType($laptopType);
        $typeAttr8->setEquipmentAttribute($batteryAttr);
        $typeAttr8->setRequired(false);
        $typeAttr8->setSort(0);
        $manager->persist($typeAttr8);

        // Equipment
        $equipmentList = [];
        $equipmentList[] = ['inventory' => 'PC-001', 'serial' => '123456789', 'type' => $pcType, 'raion' => $raion00,
            'attrs' => ['processor' => 'Intel i7', 'ram_gb' => 16, 'hdd' => ['500GB SSD', '1TB HDD']]];
        $equipmentList[] = ['inventory' => 'MON-001', 'serial' => '9876543241', 'type' => $monitorType, 'raion' => $raion41,
            'attrs' => ['diagonal_inch' => 24.5]];

        $cpuVariants = ['Intel i5', 'Intel i7', 'AMD Ryzen 5', 'AMD Ryzen 7'];
        $ramVariants = [8, 16, 32, 64];
        $hddVariants = [['256GB SSD'], ['512GB SSD'], ['1TB HDD'], ['256GB SSD', '1TB HDD']];
        $diagonalVariants = [21.5, 24, 27, 32];
        $printVariants = ['A4', 'A3'];
        $batteryVariants = [3.5, 5, 7, 9];
        $types = [$pcType, $monitorType, $printerType, $laptopType];
        $raions = [$raion00, $raion41];

        for ($i = 1; $i <= 20; $i++) {
            $type = $types[array_rand($types)];
            $raion = $raions[array_rand($raions)];
            $inventory = sprintf('%s-%03d', $type->getName() === 'ПК' ? 'PC' : ($type->getName() === 'Монитор' ? 'MON' : ($type->getName() === 'Принтер' ? 'PRN' : 'NB')), $i + 10);
            $serial = 'SN' . rand(100000, 999999) . $i;

            $attrs = [];
            if ($type === $pcType) {
                $attrs['processor'] = $cpuVariants[array_rand($cpuVariants)];
                $attrs['ram_gb'] = $ramVariants[array_rand($ramVariants)];
                if (rand(0, 1)) $attrs['hdd'] = $hddVariants[array_rand($hddVariants)];
            } elseif ($type === $monitorType) {
                $attrs['diagonal_inch'] = $diagonalVariants[array_rand($diagonalVariants)];
            } elseif ($type === $printerType) {
                $attrs['print_format'] = $printVariants[array_rand($printVariants)];
            } elseif ($type === $laptopType) {
                $attrs['processor'] = $cpuVariants[array_rand($cpuVariants)];
                $attrs['ram_gb'] = $ramVariants[array_rand($ramVariants)];
                if (rand(0, 1)) $attrs['battery_life'] = $batteryVariants[array_rand($batteryVariants)];
            }

            $equipmentList[] = [
                'inventory' => $inventory,
                'serial' => $serial,
                'type' => $type,
                'raion' => $raion,
                'attrs' => $attrs
            ];
        }

        foreach ($equipmentList as $item) {
            $eq = new Equipment();
            $eq->setInventory($item['inventory']);
            $eq->setSerial($item['serial']);
            $eq->setEquipmentType($item['type']);
            $eq->setRaion($item['raion']);
            $eq->setEquipmentAttributes($item['attrs']);
            $manager->persist($eq);
        }

        $manager->flush();
    }
}
