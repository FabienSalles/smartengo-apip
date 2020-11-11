<?php

declare(strict_types=1);

namespace Smartengo\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111185727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'remove nullable on updated at columns';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE tag ALTER updated_at SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->throwIrreversibleMigrationException();
    }
}
