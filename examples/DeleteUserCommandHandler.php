<?php
/**
 * Created by PhpStorm.
 * User: patryk.wozinski
 * Date: 20/12/2018
 * Time: 12:37
 */
declare(strict_types=1);

namespace App;


use Freeq\LifeCycle\LifeCycleInterface;

final class DeleteUserCommandHandler implements CommandHandlerInterface
{
	/** @var LifeCycleInterface */
	private $lifeCycle;

	/** @var UserRepositoryInterface */
	private $repository;

	public function __construct(LifeCycleInterface $lifeCycle, UserRepositoryInterface $repository)
	{
		$this->lifeCycle  = $lifeCycle;
		$this->repository = $repository;
	}

	/**
	 * @param DeleteUserCommand | CommandInterface $command
	 */
	public function handle(CommandInterface $command): void
	{
		$this->lifeCycle->run(function () use ($command)
		{
			$this->repository->deleteById($command->userId());
		});
	}
}
