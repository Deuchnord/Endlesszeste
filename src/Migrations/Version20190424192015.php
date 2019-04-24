<?php

/*
 * This file is part of Endlesszeste.
 *
 * Endlesszeste is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Endlesszeste is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Endlesszeste.  If not, see <https://www.gnu.org/licenses/agpl.html>.
 */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190424192015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'First version of the database';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE chapter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, number INTEGER NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F981B52E96901F54 ON chapter (number)');
        $this->addSql('CREATE TABLE author (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifier VARCHAR(255) NOT NULL, banned BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE extract (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, chapter_id INTEGER NOT NULL, author_id INTEGER DEFAULT NULL, publication_date DATETIME NOT NULL, content CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3E5A31DE579F4768 ON extract (chapter_id)');
        $this->addSql('CREATE INDEX IDX_3E5A31DEF675F31B ON extract (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('sqlite' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE extract');
    }
}
