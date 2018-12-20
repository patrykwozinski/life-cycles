<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 12:41
 */
declare(strict_types=1);

namespace App;


interface CommandHandlerInterface
{
	public function handle(CommandInterface $command): void;
}
