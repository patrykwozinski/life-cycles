<?php
/**
 * Created by PhpStorm.
 * User: freeq
 * Date: 19/12/2018
 * Time: 18:56
 */
declare(strict_types=1);

namespace Freeq\LifeCycle;


interface LifeCycleInterface
{
    public function run(callable $app);
}
