<?php

namespace Tests\Alcyon;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DatabaseTestCase extends KernelTestCase
{
    /**
     * Update schema of DataBase
     *
     * @param EntityManagerInterface $entityManager
     */
    protected function purgeDataBase()
    {
        $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        // Run the schema update tool using our entity metadata
        $metadatas = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadatas);

    }
}