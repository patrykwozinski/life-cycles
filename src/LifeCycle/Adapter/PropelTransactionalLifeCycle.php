<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 16:22
 */
declare(strict_types=1);

namespace Freeq\LifeCycle\Adapter;


use Freeq\LifeCycle\LifeCycleInterface;
use Propel\Runtime\Propel;

final class PropelTransactionalLifeCycle
{
	/** @var LifeCycleInterface */
	private $lifeCycle;

	/** @var Connection */
	private $connection;

	public function __construct(LifeCycleInterface $lifeCycle, string $connectionName)
	{
		$this->lifeCycle  = $lifeCycle;
		$this->connection = Propel::getConnection($connectionName);
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
		catch (\throwable $exception)
		{
			$this->connection->rollBack();

			throw $exception;
		}
	}
}
