<?php

    use Doctrine\ORM\Tools\Console\ConsoleRunner;

    require_once join(DIRECTORY_SEPARATOR, [__DIR__, 'doctrine.php']);

    return ConsoleRunner::createHelperSet($entityManager);
