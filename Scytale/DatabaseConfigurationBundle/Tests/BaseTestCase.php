<?php

namespace Scytale\DatabaseConfigurationBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * BaseTestCase
 */
class BaseTestCase extends WebTestCase
{
 
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;
 
    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var Symfony\Bundle\FrameworkBundle\Client
     */
    protected $client;

    /**
     * @return null
     */
    public function setup()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->client = static::createClient();
 
        $this->container = static::$kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getManager();
 
        $this->generateSchema();
 
        parent::setup();
    }

    /**
     * @return null
     */
    public function tearDown()
    {
        static::$kernel->shutdown();
 
        parent::tearDown();
    }

    /**
     * @return null
     */
    protected function generateSchema()
    {
        $metadatas = $this->getMetadatas();
 
        if (!empty($metadatas)) {
            $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
            $tool->dropDatabase();
            //$tool->dropSchema($metadatas);
            $tool->createSchema($metadatas);
        }
    }

     /**
     * @return array
     */
    protected function getMetadatas()
    {
        return $this->entityManager->getMetadataFactory()->getAllMetadata();
    }
}
