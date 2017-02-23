<?php

namespace Fusio\Adapter\Sample\Connection;

use Doctrine\DBAL\DriverManager;
use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;

class Sqlite implements ConnectionInterface
{
    public function getName()
    {
        return 'Sqlite';
    }

    public function getConnection(ParametersInterface $config)
    {
        return DriverManager::getConnection([
            'path'   => __DIR__ . '/../../todo-app.db',
            'driver' => 'pdo_sqlite',
        ]);
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory)
    {
    }
}
