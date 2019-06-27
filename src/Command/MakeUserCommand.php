<?php

namespace App\Command;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Создание Юзера')
            ->addArgument('login', InputArgument::OPTIONAL, 'login')
            ->addArgument('password', InputArgument::OPTIONAL, 'password')
            ->addArgument('name', InputArgument::OPTIONAL, 'name')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $login = $input->getArgument('login');
        $password = $input->getArgument('password');
        $name = $input->getArgument('name');

        if (! empty($login) && !empty($password) && !empty($name)) {
            $io->note('Все агрументы заполнены');
            $io->note('Создаю пользователя');

            $this->userService->createUserByLogPassName($login,$password,$name);

            $io->success('Пользователь создан');
        } else {
            $io->error('Введены не все аргументы');
        }
    }
}
