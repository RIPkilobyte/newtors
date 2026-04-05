<?php

namespace App\Tests\Controller;

use App\Entity\EquipmentAttribute;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EquipmentAttributeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;

    /** @var EntityRepository<EquipmentAttribute> */
    private EntityRepository $equipmentAttributeRepository;
    private string $path = '/equipment/attribute/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->equipmentAttributeRepository = $this->manager->getRepository(EquipmentAttribute::class);

        foreach ($this->equipmentAttributeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EquipmentAttribute index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'equipment_attribute[name]' => 'Testing',
            'equipment_attribute[label]' => 'Testing',
            'equipment_attribute[dataType]' => 'Testing',
            'equipment_attribute[isMultiple]' => 'Testing',
        ]);

        self::assertResponseRedirects('/equipment/attribute');

        self::assertSame(1, $this->equipmentAttributeRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new EquipmentAttribute();
        $fixture->setName('My Title');
        $fixture->setLabel('My Title');
        $fixture->setDataType('My Title');
        $fixture->setIsMultiple('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EquipmentAttribute');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new EquipmentAttribute();
        $fixture->setName('Value');
        $fixture->setLabel('Value');
        $fixture->setDataType('Value');
        $fixture->setIsMultiple('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'equipment_attribute[name]' => 'Something New',
            'equipment_attribute[label]' => 'Something New',
            'equipment_attribute[dataType]' => 'Something New',
            'equipment_attribute[isMultiple]' => 'Something New',
        ]);

        self::assertResponseRedirects('/equipment/attribute');

        $fixture = $this->equipmentAttributeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getLabel());
        self::assertSame('Something New', $fixture[0]->getDataType());
        self::assertSame('Something New', $fixture[0]->getIsMultiple());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new EquipmentAttribute();
        $fixture->setName('Value');
        $fixture->setLabel('Value');
        $fixture->setDataType('Value');
        $fixture->setIsMultiple('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/equipment/attribute');
        self::assertSame(0, $this->equipmentAttributeRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
