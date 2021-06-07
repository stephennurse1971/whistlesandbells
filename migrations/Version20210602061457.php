<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602061457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_court_availability ADD venue_id INT NOT NULL');
        $this->addSql('ALTER TABLE tennis_court_availability ADD CONSTRAINT FK_AB475A3E40A73EBA FOREIGN KEY (venue_id) REFERENCES tennis_venues (id)');
        $this->addSql('CREATE INDEX IDX_AB475A3E40A73EBA ON tennis_court_availability (venue_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_court_availability DROP FOREIGN KEY FK_AB475A3E40A73EBA');
        $this->addSql('DROP INDEX IDX_AB475A3E40A73EBA ON tennis_court_availability');
        $this->addSql('ALTER TABLE tennis_court_availability DROP venue_id');
    }
}
