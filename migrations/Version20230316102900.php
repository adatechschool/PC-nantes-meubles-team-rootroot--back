<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316102900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE colors_meubles (colors_id INT NOT NULL, meubles_id INT NOT NULL, INDEX IDX_D36ABA2D5C002039 (colors_id), INDEX IDX_D36ABA2DE790C529 (meubles_id), PRIMARY KEY(colors_id, meubles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE colors_meubles ADD CONSTRAINT FK_D36ABA2D5C002039 FOREIGN KEY (colors_id) REFERENCES colors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors_meubles ADD CONSTRAINT FK_D36ABA2DE790C529 FOREIGN KEY (meubles_id) REFERENCES meubles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE colors DROP meuble_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE colors_meubles DROP FOREIGN KEY FK_D36ABA2D5C002039');
        $this->addSql('ALTER TABLE colors_meubles DROP FOREIGN KEY FK_D36ABA2DE790C529');
        $this->addSql('DROP TABLE colors_meubles');
        $this->addSql('ALTER TABLE colors ADD meuble_id INT NOT NULL');
    }
}
