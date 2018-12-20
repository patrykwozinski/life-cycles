<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 12:40
 */
declare(strict_types=1);

namespace App;


final class DeleteUserCommand implements CommandInterface
{
	private $userId;

	public function __construct(int $userId)
	{
		$this->userId = $userId;
	}

	public function userId(): int
	{
		return $this->userId;
	}
}
