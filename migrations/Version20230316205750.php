<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316205750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materials (id INT AUTO_INCREMENT NOT NULL, material VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materials_furniture (materials_id INT NOT NULL, furniture_id INT NOT NULL, INDEX IDX_7751ADC3A9FC940 (materials_id), INDEX IDX_7751ADCCF5485C3 (furniture_id), PRIMARY KEY(materials_id, furniture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materials_furniture ADD CONSTRAINT FK_7751ADC3A9FC940 FOREIGN KEY (materials_id) REFERENCES materials (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materials_furniture ADD CONSTRAINT FK_7751ADCCF5485C3 FOREIGN KEY (furniture_id) REFERENCES furniture (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materials_furniture DROP FOREIGN KEY FK_7751ADC3A9FC940');
        $this->addSql('ALTER TABLE materials_furniture DROP FOREIGN KEY FK_7751ADCCF5485C3');
        $this->addSql('DROP TABLE materials');
        $this->addSql('DROP TABLE materials_furniture');
    }
}
