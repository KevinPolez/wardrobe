<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$app = require_once __DIR__.'/../bootstrap.php';

$entityManager = $app['orm.em'];

return ConsoleRunner::createHelperSet($entityManager);