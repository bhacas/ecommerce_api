<?php

namespace App\Catalog\Interface\Command;

use App\Catalog\Application\Command\AddProductMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:test:add-product',
    description: 'Test command to add a product via the message bus',
)]
final class TestAddProductCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Nazwa produktu', 'Produkt z Konsoli')
            ->addArgument('price', InputArgument::OPTIONAL, 'Cena produktu', 1999);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');
        $price = (int) $input->getArgument('price');

        $io->note(sprintf('Preparing message: "%s"', $name));

        $message = new AddProductMessage(
            $name,
            $price,
            'PLN',
            25,
            'Product description from console',
        );

        $this->messageBus->dispatch($message);

        $io->success('Product message dispatched successfully!');

        return Command::SUCCESS;
    }
}
