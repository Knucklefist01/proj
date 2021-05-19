<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518095517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, value FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, value INTEGER NOT NULL)');
        $this->addSql('INSERT INTO score (id, value) SELECT id, value FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score ADD COLUMN name VARCHAR(255) NOT NULL COLLATE BINARY');
    }
}
