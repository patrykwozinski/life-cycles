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

final class SpyLifeCycle implements LifeCycleInterface
{
	/** @var int */
	private $whenSuccess;

	/** @var int */
	private $runned;

	public function __construct(int $whenSuccess)
	{
		$this->whenSuccess = $whenSuccess;
		$this->runned      = 1;
	}

	public function run(callable $app)
	{
		if ($this->whenSuccess === $this->runned)
		{
			return $app();
		}

		++$this->runned;

		throw new \RuntimeException('Error!');
	}
}
