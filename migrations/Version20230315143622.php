<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315143622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meubles ADD category VARCHAR(255) NOT NULL, ADD title VARCHAR(255) NOT NULL, ADD dimension_id INT NOT NULL, DROP type, DROP couleur, CHANGE prix price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meubles ADD type VARCHAR(255) NOT NULL, ADD prix INT NOT NULL, ADD couleur VARCHAR(255) NOT NULL, DROP category, DROP price, DROP title, DROP dimension_id');
    }
}
