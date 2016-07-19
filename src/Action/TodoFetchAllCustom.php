<?php

namespace Fusio\Adapter\Sample\Action;

use Doctrine\DBAL\Connection;
use Fusio\Engine\ActionInterface;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;
use RuntimeException;

class TodoFetchAllCustom implements ActionInterface
{
    /**
     * @Inject
     * @var \Fusio\Engine\ConnectorInterface
     */
    protected $connector;

    /**
     * @Inject
     * @var \Fusio\Engine\Response\FactoryInterface
     */
    protected $response;

    public function getName()
    {
        return 'Todo-Fetch-Custom';
    }

    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        $connection = $this->connector->getConnection($configuration->get('connection'));

        if ($connection instanceof Connection) {
            $count   = $connection->fetchColumn('SELECT COUNT(*) FROM app_todo');
            $entries = $connection->fetchAll('SELECT * FROM app_todo ORDER BY insertDate DESC LIMIT 0, 8');

            return $this->response->build(200, [], [
                'totalCount' => $count,
                'entry'      => $entries,
            ]);
        } else {
            throw new RuntimeException('Given connection must be a DBAL connection');
        }
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory)
    {
        $builder->add($elementFactory->newConnection('connection', 'Connection', 'The SQL connection which should be used'));
    }
}
