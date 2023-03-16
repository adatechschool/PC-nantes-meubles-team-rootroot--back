<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316204103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE furniture (id INT AUTO_INCREMENT NOT NULL, categoy_id INT NOT NULL, description VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, dimesion VARCHAR(255) DEFAULT NULL, INDEX IDX_665DDAB3E2729280 (categoy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, furniture_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_876E0D9CF5485C3 (furniture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE furniture ADD CONSTRAINT FK_665DDAB3E2729280 FOREIGN KEY (categoy_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9CF5485C3 FOREIGN KEY (furniture_id) REFERENCES furniture (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE furniture DROP FOREIGN KEY FK_665DDAB3E2729280');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9CF5485C3');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE furniture');
        $this->addSql('DROP TABLE photos');
    }
}
