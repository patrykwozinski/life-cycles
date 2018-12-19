<?php
/**
 * Created by PhpStorm.
 * User: freeq
 * Date: 19/12/2018
 * Time: 18:56
 */
declare(strict_types=1);

namespace Tests\Freeq\LifeCycle;


use Freeq\LifeCycle\InvokeLifeCycle;

final class InvokeLifeCycleTest extends TestCase
{
    public function testItInvokesWhenPushedFunction(): void
    {
        // Given
        $user = 'Patryk';
        $testing = function () use ($user) {
            return \sprintf('Hello World %s', $user);
        };
        $lifeCycle = new InvokeLifeCycle;

        // When
        $response = $lifeCycle->run($testing);

        $this->assertEquals('Hello World Patryk', $response);
    }
}
