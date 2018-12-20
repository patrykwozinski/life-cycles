<?php
/**
 * Created by PhpStorm.
 * User: freeq
 * Date: 19/12/2018
 * Time: 19:05
 */
declare(strict_types=1);

namespace Freeq\LifeCycle;


final class RepeaterLifeCycle implements LifeCycleInterface
{
	/** @var LifeCycleInterface */
	private $lifeCycle;

	/** @var int */
	private $retryLimit;

	/** @var int */
	private $currentTry;

	public function __construct(LifeCycleInterface $lifeCycle, int $retryLimit)
	{
		$this->lifeCycle  = $lifeCycle;
		$this->retryLimit = $retryLimit;
		$this->currentTry = 1;
	}

	public function run(callable $app)
	{
		try
		{
			return $this->lifeCycle->run($app);
		}
		catch (\Exception $exception)
		{
			if ($this->currentTry < $this->retryLimit)
			{
				++$this->currentTry;

				return $this->run($app);
			}

			throw $exception;
		}
	}
}
