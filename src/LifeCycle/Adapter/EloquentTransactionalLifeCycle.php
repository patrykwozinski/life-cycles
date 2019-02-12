<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 12:49
 */
declare(strict_types=1);

namespace Freeq\LifeCycle\Adapter;


use Freeq\LifeCycle\LifeCycleInterface;
use DB;

final class EloquentTransactionalLifeCycle implements LifeCycleInterface
{
	/** @var LifeCycleInterface */
	private $lifeCycle;

	public function __construct(LifeCycleInterface $lifeCycle)
	{
		$this->lifeCycle = $lifeCycle;
	}

	public function run(callable $app)
	{
		DB::beginTransaction();

		try
		{
			$response = $this->lifeCycle->run($app);

			DB::commit();

			return $response;
		}
		catch (\throwable $exception)
		{
			DB::rollBack();

			throw $exception;
		}
	}
}
