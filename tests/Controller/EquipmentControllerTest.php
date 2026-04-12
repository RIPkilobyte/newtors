<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Equipment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EquipmentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;

    /** @var EntityRepository<Equipment> */
    private EntityRepository $equipmentRepository;
    private string $path = '/equipment/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->equipmentRepository = $this->manager->getRepository(Equipment::class);

        foreach ($this->equipmentRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Equipment index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'equipment[inventory]' => 'Testing',
            'equipment[serial]' => 'Testing',
            'equipment[attributes]' => 'Testing',
            'equipment[raion]' => 'Testing',
            'equipment[type]' => 'Testing',
        ]);

        self::assertResponseRedirects('/equipment');

        self::assertSame(1, $this->equipmentRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Equipment();
        $fixture->setInventory('My Title');
        $fixture->setSerial('My Title');
        $fixture->setAttributes('My Title');
        $fixture->setRaion('My Title');
        $fixture->setType('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Equipment');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Equipment();
        $fixture->setInventory('Value');
        $fixture->setSerial('Value');
        $fixture->setAttributes('Value');
        $fixture->setRaion('Value');
        $fixture->setType('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'equipment[inventory]' => 'Something New',
            'equipment[serial]' => 'Something New',
            'equipment[attributes]' => 'Something New',
            'equipment[raion]' => 'Something New',
            'equipment[type]' => 'Something New',
        ]);

        self::assertResponseRedirects('/equipment');

        $fixture = $this->equipmentRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getInventory());
        self::assertSame('Something New', $fixture[0]->getSerial());
        self::assertSame('Something New', $fixture[0]->getAttributes());
        self::assertSame('Something New', $fixture[0]->getRaion());
        self::assertSame('Something New', $fixture[0]->getType());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Equipment();
        $fixture->setInventory('Value');
        $fixture->setSerial('Value');
        $fixture->setAttributes('Value');
        $fixture->setRaion('Value');
        $fixture->setType('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/equipment');
        self::assertSame(0, $this->equipmentRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
