<?php
/**
 * Created by PhpStorm.
 * User: freeq
 * Date: 19/12/2018
 * Time: 19:04
 */
declare(strict_types=1);

namespace Tests\Freeq\LifeCycle;


use Freeq\LifeCycle\RepeaterLifeCycle;
use Tests\Freeq\LifeCycle\TestDouble\SpyLifeCycle;

final class RepeaterLifeCycleTest extends TestCase
{
	public function test_it_fails_twice_before_returning_string(): void
	{
		// Given
		$helloWorld       = 'Hello World!';
		$testingCallback  = function () use ($helloWorld) {
			return $helloWorld;
		};
		$repaterLifeCycle = new RepeaterLifeCycle(new SpyLifeCycle(3), 3);

		// When
		$response = $repaterLifeCycle->run($testingCallback);

		// Then
		$this->assertEquals($helloWorld, $response);
	}

	public function test_it_throws_exception_because_of_exceeded_limit(): void
	{
		$this->expectException(\RuntimeException::class);

		// Given
		$testingCallback  = function () {
			return 'Hello world';
		};
		$repaterLifeCycle = new RepeaterLifeCycle(new SpyLifeCycle(2), 1);

		// When
		$repaterLifeCycle->run($testingCallback);
	}

	public function test_it_throws_exception_because_of_exception_not_handled(): void
	{
		$this->expectException(\RuntimeException::class);

		// Given
		$handledException = \LogicException::class;
		$testingCallback  = function () {
			return 'Hello world';
		};
		$repaterLifeCycle = new RepeaterLifeCycle(new SpyLifeCycle(2), 1, $handledException);

		// When
		$repaterLifeCycle->run($testingCallback);
	}

	public function test_it_returns_string_because_of_exception_is_handled(): void
	{
		// Given
		$handledException = \RuntimeException::class;
		$testingCallback  = function () {
			return 'Hello world';
		};
		$repaterLifeCycle = new RepeaterLifeCycle(new SpyLifeCycle(2), 2, $handledException);

		// When
		$response = $repaterLifeCycle->run($testingCallback);

		// Then
		$this->assertEquals('Hello world', $response);
	}
}
