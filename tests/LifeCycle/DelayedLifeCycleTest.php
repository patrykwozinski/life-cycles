<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 13:21
 */
declare(strict_types=1);

namespace Tests\Freeq\LifeCycle;


use Freeq\LifeCycle\DelayedLifeCycle;
use Freeq\LifeCycle\RepeaterLifeCycle;
use Tests\Freeq\LifeCycle\TestDouble\SpyTimeLifeCycle;

final class DelayedLifeCycleTest extends TestCase
{
	public function test_it_delays_expected_time_when_runned(): void
	{
		// Given
		$spyLifeTime       = new SpyTimeLifeCycle(2, 500);
		$delayedLifeCycle  = new DelayedLifeCycle($spyLifeTime, 500);
		$repeaterLifecycle = new RepeaterLifeCycle($delayedLifeCycle, 2);

		// When
		$response = $repeaterLifecycle->run(function () {
			return 'Hello!';
		});

		// Then
		$this->assertEquals('Hello!', $response);
		$this->assertTrue($spyLifeTime->isExpectedTimeDiff());
	}
}
