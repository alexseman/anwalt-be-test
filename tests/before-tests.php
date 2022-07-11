<?php

declare(strict_types=1);

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

$kernel = new Kernel('test', true);
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);
//$application->run(new StringInput('doctrine:truncate'));
//$application->run(new StringInput('doctrine:migrations:migrate --no-interaction'));
