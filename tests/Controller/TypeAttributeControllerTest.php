<?php

namespace App\Tests\Controller;

use App\Entity\TypeAttribute;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TypeAttributeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;

    /** @var EntityRepository<TypeAttribute> */
    private EntityRepository $typeAttributeRepository;
    private string $path = '/type/attribute/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->typeAttributeRepository = $this->manager->getRepository(TypeAttribute::class);

        foreach ($this->typeAttributeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TypeAttribute index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'type_attribute[required]' => 'Testing',
            'type_attribute[sortOrder]' => 'Testing',
            'type_attribute[type]' => 'Testing',
            'type_attribute[attribute]' => 'Testing',
        ]);

        self::assertResponseRedirects('/type/attribute');

        self::assertSame(1, $this->typeAttributeRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new TypeAttribute();
        $fixture->setRequired('My Title');
        $fixture->setSortOrder('My Title');
        $fixture->setType('My Title');
        $fixture->setAttribute('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TypeAttribute');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new TypeAttribute();
        $fixture->setRequired('Value');
        $fixture->setSortOrder('Value');
        $fixture->setType('Value');
        $fixture->setAttribute('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'type_attribute[required]' => 'Something New',
            'type_attribute[sortOrder]' => 'Something New',
            'type_attribute[type]' => 'Something New',
            'type_attribute[attribute]' => 'Something New',
        ]);

        self::assertResponseRedirects('/type/attribute');

        $fixture = $this->typeAttributeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getRequired());
        self::assertSame('Something New', $fixture[0]->getSortOrder());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getAttribute());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new TypeAttribute();
        $fixture->setRequired('Value');
        $fixture->setSortOrder('Value');
        $fixture->setType('Value');
        $fixture->setAttribute('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/type/attribute');
        self::assertSame(0, $this->typeAttributeRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
