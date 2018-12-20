<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 12:45
 */
declare(strict_types=1);

namespace Freeq\LifeCycle\Adapter;


use Freeq\LifeCycle\LifeCycleInterface;
use Doctrine\DBAL\Connection;

final class DoctrineTransactionalLifeCycle implements LifeCycleInterface
{
	/** @var LifeCycleInterface */
	private $lifeCycle;

	/** @var Connection */
	private $connection;

	public function __construct(LifeCycleInterface $lifeCycle, Connection $connection)
	{
		$this->lifeCycle  = $lifeCycle;
		$this->connection = $connection;
	}

	public function run(callable $app)
	{
		$this->connection->beginTransaction();

		try
		{
			$response = $this->lifeCycle->run($app);

			$this->connection->commit();

			return $response;
		}
		catch (\Exception $exception)
		{
			$this->connection->rollBack();

			throw $exception;
		}
	}
}
