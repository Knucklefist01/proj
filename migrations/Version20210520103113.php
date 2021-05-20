<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520103113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bathroom ADD COLUMN house_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE bedroom ADD COLUMN house_id INTEGER DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD COLUMN house_id INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__bathroom AS SELECT id, name, windows, floor, sinks, toilets FROM bathroom');
        $this->addSql('DROP TABLE bathroom');
        $this->addSql('CREATE TABLE bathroom (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, windows INTEGER NOT NULL, floor INTEGER NOT NULL, sinks INTEGER NOT NULL, toilets INTEGER NOT NULL)');
        $this->addSql('INSERT INTO bathroom (id, name, windows, floor, sinks, toilets) SELECT id, name, windows, floor, sinks, toilets FROM __temp__bathroom');
        $this->addSql('DROP TABLE __temp__bathroom');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bedroom AS SELECT id, name, windows, floor, bed, en_suite FROM bedroom');
        $this->addSql('DROP TABLE bedroom');
        $this->addSql('CREATE TABLE bedroom (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, windows INTEGER NOT NULL, floor INTEGER NOT NULL, bed VARCHAR(255) NOT NULL, en_suite INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO bedroom (id, name, windows, floor, bed, en_suite) SELECT id, name, windows, floor, bed, en_suite FROM __temp__bedroom');
        $this->addSql('DROP TABLE __temp__bedroom');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, name, windows, floor FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, windows INTEGER NOT NULL, floor INTEGER NOT NULL)');
        $this->addSql('INSERT INTO room (id, name, windows, floor) SELECT id, name, windows, floor FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
    }
}
