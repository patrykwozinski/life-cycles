<?php
/**
 * Created by PhpStorm.
 * User: freeq
 * Date: 2018-12-24
 * Time: 00:18
 */
declare(strict_types=1);

namespace Freeq\LifeCycle;


final class PeriodicLifeCycle implements LifeCycleInterface
{
    /** @var LifeCycleInterface */
    private $lifeCycle;

    /** @var int */
    private $timeout; // millis

    /** @var int */
    private $repeatInterval; // millis

    public function __construct(LifeCycleInterface $lifeCycle, int $timeout, int $repeatInterval)
    {
        $this->lifeCycle = $lifeCycle;
        $this->timeout = $timeout;
        $this->repeatInterval = $repeatInterval;
    }

    public function run(callable $app)
    {
        $timeout = \microtime(true) + $this->timeout / 1000;

        do
        {
            try
            {
                return $this->lifeCycle->run($app);
            }
            catch (\throwable $exception)
            {
                \usleep($this->repeatInterval * 1000);
            }
        }
        while (\microtime(true) < $timeout);
    }
}
