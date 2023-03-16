<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316101506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, meuble_id INT NOT NULL, content LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meubles CHANGE category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE meubles ADD CONSTRAINT FK_1F62B1A512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_1F62B1A512469DE2 ON meubles (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photos');
        $this->addSql('ALTER TABLE meubles DROP FOREIGN KEY FK_1F62B1A512469DE2');
        $this->addSql('DROP INDEX IDX_1F62B1A512469DE2 ON meubles');
        $this->addSql('ALTER TABLE meubles CHANGE category_id category_id VARCHAR(255) NOT NULL');
    }
}
