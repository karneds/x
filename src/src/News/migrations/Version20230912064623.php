<?php

declare(strict_types=1);

namespace News\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230912064623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $newsTable = $schema->createTable('news');
        
        $newsTable->addColumn('id', 'uuid');

        $newsTable->addColumn('title', 'string');
        $newsTable->addColumn('text', 'text');
        $newsTable->addColumn('created_date', 'text');
        $newsTable->addColumn('status', 'smallint')->setNotnull(false);
        
        $newsTable->setPrimaryKey(['id']);

        $newsTable->addIndex(['statuss']);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
