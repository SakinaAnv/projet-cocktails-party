<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220417104012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_cocktail (order_id INT NOT NULL, cocktail_id INT NOT NULL, INDEX IDX_9AB1F6658D9F6D38 (order_id), INDEX IDX_9AB1F665CD6F76C6 (cocktail_id), PRIMARY KEY(order_id, cocktail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_cocktail ADD CONSTRAINT FK_9AB1F6658D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_cocktail ADD CONSTRAINT FK_9AB1F665CD6F76C6 FOREIGN KEY (cocktail_id) REFERENCES cocktail (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_cocktail');
    }
}
