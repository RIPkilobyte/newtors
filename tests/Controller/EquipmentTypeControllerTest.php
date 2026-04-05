<?php

namespace App\Tests\Controller;

use App\Entity\EquipmentType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EquipmentTypeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;

    /** @var EntityRepository<EquipmentType> */
    private EntityRepository $equipmentTypeRepository;
    private string $path = '/equipment/type/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->equipmentTypeRepository = $this->manager->getRepository(EquipmentType::class);

        foreach ($this->equipmentTypeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EquipmentType index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'equipment_type[name]' => 'Testing',
        ]);

        self::assertResponseRedirects('/equipment/type');

        self::assertSame(1, $this->equipmentTypeRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new EquipmentType();
        $fixture->setName('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EquipmentType');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new EquipmentType();
        $fixture->setName('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'equipment_type[name]' => 'Something New',
        ]);

        self::assertResponseRedirects('/equipment/type');

        $fixture = $this->equipmentTypeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new EquipmentType();
        $fixture->setName('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/equipment/type');
        self::assertSame(0, $this->equipmentTypeRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
