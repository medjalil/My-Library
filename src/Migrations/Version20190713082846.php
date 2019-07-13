<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190713082846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_CBE5A33112469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, category_id, title, author, abstract, created_at, code FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, author VARCHAR(255) NOT NULL COLLATE BINARY, abstract CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, code INTEGER NOT NULL, CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO book (id, category_id, title, author, abstract, created_at, code) SELECT id, category_id, title, author, abstract, created_at, code FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
        $this->addSql('DROP INDEX IDX_B164EFF816A2B381');
        $this->addSql('DROP INDEX IDX_B164EFF8A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_book AS SELECT user_id, book_id FROM user_book');
        $this->addSql('DROP TABLE user_book');
        $this->addSql('CREATE TABLE user_book (user_id INTEGER NOT NULL, book_id INTEGER NOT NULL, PRIMARY KEY(user_id, book_id), CONSTRAINT FK_B164EFF8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B164EFF816A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_book (user_id, book_id) SELECT user_id, book_id FROM __temp__user_book');
        $this->addSql('DROP TABLE __temp__user_book');
        $this->addSql('CREATE INDEX IDX_B164EFF816A2B381 ON user_book (book_id)');
        $this->addSql('CREATE INDEX IDX_B164EFF8A76ED395 ON user_book (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_CBE5A33112469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, category_id, title, author, abstract, created_at, code FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, abstract CLOB NOT NULL, created_at DATETIME NOT NULL, code INTEGER NOT NULL)');
        $this->addSql('INSERT INTO book (id, category_id, title, author, abstract, created_at, code) SELECT id, category_id, title, author, abstract, created_at, code FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
        $this->addSql('DROP INDEX IDX_B164EFF8A76ED395');
        $this->addSql('DROP INDEX IDX_B164EFF816A2B381');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_book AS SELECT user_id, book_id FROM user_book');
        $this->addSql('DROP TABLE user_book');
        $this->addSql('CREATE TABLE user_book (user_id INTEGER NOT NULL, book_id INTEGER NOT NULL, PRIMARY KEY(user_id, book_id))');
        $this->addSql('INSERT INTO user_book (user_id, book_id) SELECT user_id, book_id FROM __temp__user_book');
        $this->addSql('DROP TABLE __temp__user_book');
        $this->addSql('CREATE INDEX IDX_B164EFF8A76ED395 ON user_book (user_id)');
        $this->addSql('CREATE INDEX IDX_B164EFF816A2B381 ON user_book (book_id)');
    }
}
