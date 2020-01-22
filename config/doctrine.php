<?php

    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\Tools\Setup;


    require_once join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);


    // Create a simple "default" Doctrine ORM configuration for Annotations
    $entitiesPath = [
        join(DIRECTORY_SEPARATOR, [dirname(__DIR__), "src", "Entity"])
    ];

    $isDevMode = true;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;
    $config = Setup::createAnnotationMetadataConfiguration(
        $entitiesPath,
        $isDevMode, $proxyDir,
        $cache,
        $useSimpleAnnotationReader
    );

    // database configuration parameters
    $conn = array(
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'charset'  => 'utf8',
        'user'     => 'root',
        'password' => 'root',
        'dbname'   => 'member_area',
    );

    // obtaining the entity manager
    $entityManager = EntityManager::create($conn, $config);