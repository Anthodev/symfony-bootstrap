<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250215172911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE roles (id UUID NOT NULL, label VARCHAR(255) NOT NULL, code VARCHAR(32) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'NOW()\' NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'NOW()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B63E2EC7EA750E8 ON roles (label)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B63E2EC777153098 ON roles (code)');
        $this->addSql('CREATE TABLE users (email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'NOW()\' NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'NOW()\' NOT NULL, role_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('CREATE INDEX IDX_1483A5E9D60322AC ON users (role_id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9D60322AC');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE users');
    }
}
