<?php

namespace Smartengo\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111002507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialize Article table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE article (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, content TEXT NOT NULL, draft BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id));');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->throwIrreversibleMigrationException();
    }
}
