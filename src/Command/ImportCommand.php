<?php declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

#[AsCommand(name: 'import')]
class ImportCommand extends Command {
  private EntityManagerInterface $entityManager;

  public function __construct(EntityManagerInterface $entityManager) {
    parent::__construct();
    $this->entityManager = $entityManager;
  }

  protected function execute(InputInterface $input, OutputInterface $output): int {
    $productsCsv = ProductService::readProductsFromCsv(dirname(__FILE__) . '/stock.csv');

    foreach ($productsCsv['correct'] as $productCorrect) {
      try {
        $this->entityManager->persist($productCorrect);
        $this->entityManager->flush();
      } catch (\Throwable $e) {
        echo $productCorrect->getName() . PHP_EOL;
        echo $e->getMessage() . PHP_EOL;
        // doesn't work...
        // $this->entityManager = $this->entityManager->getConnection()->getEntityManager();
      }
    }

    echo 'Importing finished';

    return Command::SUCCESS;
  }
}