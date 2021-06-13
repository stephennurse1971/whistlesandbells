<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609053127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_player_availability DROP FOREIGN KEY FK_123CAE01C0CD1D3B');
        $this->addSql('DROP INDEX IDX_123CAE01C0CD1D3B ON tennis_player_availability');
        $this->addSql('ALTER TABLE tennis_player_availability DROP tennis_player_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_player_availability ADD tennis_player_id INT NOT NULL');
        $this->addSql('ALTER TABLE tennis_player_availability ADD CONSTRAINT FK_123CAE01C0CD1D3B FOREIGN KEY (tennis_player_id) REFERENCES tennis_players (id)');
        $this->addSql('CREATE INDEX IDX_123CAE01C0CD1D3B ON tennis_player_availability (tennis_player_id)');
    }
}
