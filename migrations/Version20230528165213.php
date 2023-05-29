<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230528165213 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create and fill products table';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `products` (
                `id` BIGSERIAL NOT NULL, 
                `title` VARCHAR(255) NOT NULL, 
                `price` INT DEFAULT 1 NOT NULL, 
                `created_at` TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, 
                PRIMARY KEY(`id`)
            )
        ');
        $this->addSql("COMMENT ON TABLE `products` IS 'Товар'");
        $this->addSql("COMMENT ON COLUMN `products`.`title` IS 'Название товара'");

        $this->addSql("INSERT INTO `products` (`title`, `price`, `created_at`) VALUES ('Iphone', '10000', '2023-05-27 07:05:58.000000')");
        $this->addSql("INSERT INTO `products` (`title`, `price`, `created_at`) VALUES ('Наушники', '2000', '2023-05-27 07:05:58.000000')");
        $this->addSql("INSERT INTO `products` (`title`, `price`, `created_at`) VALUES ('Чехол', '1000', '2023-05-27 07:05:58.000000')");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `products`');
    }
}
