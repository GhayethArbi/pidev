<?php

namespace App\Test\Controller;

use App\Entity\PlanNutritionnel;
use App\Repository\PlanNutritionnelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanNutritionnelControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PlanNutritionnelRepository $repository;
    private string $path = '/plan/nutrtionnel/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PlanNutritionnel::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PlanNutritionnel index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'plan_nutritionnel[name]' => 'Testing',
            'plan_nutritionnel[date]' => 'Testing',
            'plan_nutritionnel[recettes]' => 'Testing',
        ]);

        self::assertResponseRedirects('/plan/nutrtionnel/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PlanNutritionnel();
        $fixture->setName('My Title');
        $fixture->setDate('My Title');
        $fixture->setRecettes('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PlanNutritionnel');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PlanNutritionnel();
        $fixture->setName('My Title');
        $fixture->setDate('My Title');
        $fixture->setRecettes('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'plan_nutritionnel[name]' => 'Something New',
            'plan_nutritionnel[date]' => 'Something New',
            'plan_nutritionnel[recettes]' => 'Something New',
        ]);

        self::assertResponseRedirects('/plan/nutrtionnel/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getRecettes());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PlanNutritionnel();
        $fixture->setName('My Title');
        $fixture->setDate('My Title');
        $fixture->setRecettes('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/plan/nutrtionnel/');
    }
}
