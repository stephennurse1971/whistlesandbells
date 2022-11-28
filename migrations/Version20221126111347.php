<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126111347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_locations DROP FOREIGN KEY FK_1A181C9BA76ED395');
        $this->addSql('DROP INDEX IDX_1A181C9BA76ED395 ON photo_locations');
        $this->addSql('ALTER TABLE photo_locations DROP user_id, DROP group_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_locations ADD user_id INT NOT NULL, ADD group_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE photo_locations ADD CONSTRAINT FK_1A181C9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1A181C9BA76ED395 ON photo_locations (user_id)');
    }
}
