<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623045633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_venues DROP FOREIGN KEY FK_DB2A79A9A76ED395');
        $this->addSql('DROP INDEX IDX_DB2A79A9A76ED395 ON tennis_venues');
        $this->addSql('ALTER TABLE tennis_venues DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_venues ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tennis_venues ADD CONSTRAINT FK_DB2A79A9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DB2A79A9A76ED395 ON tennis_venues (user_id)');
    }
}
