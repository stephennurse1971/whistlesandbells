<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120062136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cms_copy ADD content_title VARCHAR(255) DEFAULT NULL, ADD content_text_fr LONGTEXT DEFAULT NULL, ADD content_text_de LONGTEXT DEFAULT NULL, ADD content_title_fr VARCHAR(255) DEFAULT NULL, ADD content_title_de VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cms_copy DROP content_title, DROP content_text_fr, DROP content_text_de, DROP content_title_fr, DROP content_title_de');
    }
}
