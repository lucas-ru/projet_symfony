<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430174234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat ADD COLUMN id_post INTEGER NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE chat ADD COLUMN id_comment INTEGER NOT NULL DEFAULT 1');
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('DROP INDEX IDX_9474526CF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, author_id, post_id, content, created_at, is_deleted FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, is_deleted BOOLEAN NOT NULL, CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, author_id, post_id, content, created_at, is_deleted) SELECT id, author_id, post_id, content, created_at, is_deleted FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('DROP INDEX IDX_CC0869731A9A7125');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message_chat AS SELECT id, chat_id, content, created_at, author_msg FROM message_chat');
        $this->addSql('DROP TABLE message_chat');
        $this->addSql('CREATE TABLE message_chat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, chat_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, author_msg VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_CC0869731A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message_chat (id, chat_id, content, created_at, author_msg) SELECT id, chat_id, content, created_at, author_msg FROM __temp__message_chat');
        $this->addSql('DROP TABLE __temp__message_chat');
        $this->addSql('CREATE INDEX IDX_CC0869731A9A7125 ON message_chat (chat_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, author_id, content, create_at, is_published, is_deleted, title FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL COLLATE BINARY, create_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, author_id, content, create_at, is_published, is_deleted, title) SELECT id, author_id, content, create_at, is_published, is_deleted, title FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__chat AS SELECT id, name, id_post_author, id_comment_author FROM chat');
        $this->addSql('DROP TABLE chat');
        $this->addSql('CREATE TABLE chat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, id_post_author INTEGER NOT NULL, id_comment_author INTEGER NOT NULL)');
        $this->addSql('INSERT INTO chat (id, name, id_post_author, id_comment_author) SELECT id, name, id_post_author, id_comment_author FROM __temp__chat');
        $this->addSql('DROP TABLE __temp__chat');
        $this->addSql('DROP INDEX IDX_9474526CF675F31B');
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, author_id, post_id, content, created_at, is_deleted FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, post_id INTEGER NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, is_deleted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO comment (id, author_id, post_id, content, created_at, is_deleted) SELECT id, author_id, post_id, content, created_at, is_deleted FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('DROP INDEX IDX_CC0869731A9A7125');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message_chat AS SELECT id, chat_id, content, created_at, author_msg FROM message_chat');
        $this->addSql('DROP TABLE message_chat');
        $this->addSql('CREATE TABLE message_chat (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, chat_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, author_msg VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO message_chat (id, chat_id, content, created_at, author_msg) SELECT id, chat_id, content, created_at, author_msg FROM __temp__message_chat');
        $this->addSql('DROP TABLE __temp__message_chat');
        $this->addSql('CREATE INDEX IDX_CC0869731A9A7125 ON message_chat (chat_id)');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, author_id, content, create_at, is_published, is_deleted, title FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO post (id, author_id, content, create_at, is_published, is_deleted, title) SELECT id, author_id, content, create_at, is_published, is_deleted, title FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
    }
}
