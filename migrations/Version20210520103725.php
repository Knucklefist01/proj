<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520103725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bathroom2house');
        $this->addSql('DROP TABLE bedroom2house');
        $this->addSql('DROP TABLE room2house');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bathroom2house (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, house_id INTEGER NOT NULL, bathroom_id INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE bedroom2house (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, house_id INTEGER NOT NULL, bedroom_id INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE room2house (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, house_id INTEGER NOT NULL, room_id INTEGER NOT NULL)');
    }
}
