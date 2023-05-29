<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\IdTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products', options: ['comment' => 'Товар'])]
class Product
{
    use IdTrait, CreatedAtTrait, UpdatedAtTrait;

    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false, options: ['comment' => 'Название товара'])]
    private ?string $title;

    #[ORM\Column(name: 'price', type: 'integer', nullable: false, options: ['default' => 1])]
    private int $price = 1;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
}
