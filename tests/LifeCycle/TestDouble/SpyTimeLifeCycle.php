<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 10:22
 */
declare(strict_types=1);

namespace Tests\Freeq\LifeCycle\TestDouble;


use Freeq\LifeCycle\LifeCycleInterface;

final class SpyTimeLifeCycle implements LifeCycleInterface
{
	/** @var int */
	private $whenSuccess;

	/** @var int */
	private $expectedTimeDiff;

	/** @var int */
	private $runned;

	/** @var int */
	private $firstExecution;

	/** @var int */
	private $lastExecution;

	public function __construct(int $whenSuccess, int $expectedTimeDiff)
	{
		$this->whenSuccess      = $whenSuccess;
		$this->expectedTimeDiff = $expectedTimeDiff;
		$this->runned           = 1;
		$this->firstExecution   = \microtime(true) * 1000;
	}

	public function run(callable $app)
	{
		if ($this->whenSuccess === $this->runned)
		{
			$this->lastExecution = \microtime(true) * 1000;

			return $app();
		}

		++$this->runned;

		throw new \RuntimeException('Error!');
	}

	public function isExpectedTimeDiff(): bool
	{
		return ($this->lastExecution - $this->firstExecution) > $this->expectedTimeDiff;
	}
}
