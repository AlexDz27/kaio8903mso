<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use \DateTimeImmutable;
use App\Service\ProductService;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable());
        $this->setUpdatedAt(new DateTimeImmutable());
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer", options: ["unsigned" => true])]
    private int $id;

    #[ORM\Column(length: 50)]
    private string $name;

    #[ORM\Column(name: "descr", length: 255)]
    private string $description;

    #[ORM\Column(length: 10, unique: true)]
    private string $code;

    #[ORM\Column(type: "integer", options: ["unsigned" => true])]
    private int $stock;

    #[ORM\Column(type: "decimal", precision: 15, scale: 2)]
    private string $price;

    // TODO: Discontinued

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $discontinuedAt = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int|string $stock): static
    {
        $this->stock = (int) $stock;

        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        // Price might be something like "$4.33" — need to use filter to safely convert to "4.33",
        // otherwise the database would complain about symbols like "$"
        $priceFiltered = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $this->price = $priceFiltered;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDiscontinuedAt(): ?DateTimeImmutable
    {
        return $this->discontinuedAt;
    }

    public function setDiscontinuedAt(?DateTimeImmutable $discontinuedAt): static
    {
        $this->discontinuedAt = $discontinuedAt;

        return $this;
    }
}
