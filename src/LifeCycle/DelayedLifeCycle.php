<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 13:04
 */
declare(strict_types=1);

namespace Freeq\LifeCycle;


final class DelayedLifeCycle implements LifeCycleInterface
{
	/** @var LifeCycleInterface */
	private $lifeCycle;

	/** @var int */
	private $delayMillis; // milliseconds

	/** @var bool */
	private $executed;

	public function __construct(LifeCycleInterface $lifeCycle, int $delayMillis)
	{
		$this->lifeCycle   = $lifeCycle;
		$this->delayMillis = $delayMillis;
		$this->executed    = false;
	}

	public function run(callable $app)
	{
		if ($this->executed)
		{
			\usleep($this->delayMillis * 1000);
		}

		$this->executed = true;

		return $this->lifeCycle->run($app);
	}
}
