<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'create-user',
    description: 'Creates a new user.',
    aliases: ['app:add-user'],
    hidden: false,
)]
class CreateUserCommand extends Command
{
    protected static $defaultDescription = 'Creates a new user.';

    private $entityManager;
    private $userPasswordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;


        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to create a user...')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output, ): int
    {

        $em = $this->entityManager;

        $pass = $input->getArgument('password');
        $email = $input->getArgument('email');


        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $output->writeln('email: '.$email);
        $output->writeln('Password: '.$pass);

        $user = new User();
        $user->setEmail($email);
//        $user->setPassword($pass);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $pass
            )
        );

        $em->persist($user);
        $em->flush();

        $output->writeln('User successfully created!');

        return Command::SUCCESS;
    }
}
