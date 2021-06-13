<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609053345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_player_availability ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tennis_player_availability ADD CONSTRAINT FK_123CAE01A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_123CAE01A76ED395 ON tennis_player_availability (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_player_availability DROP FOREIGN KEY FK_123CAE01A76ED395');
        $this->addSql('DROP INDEX IDX_123CAE01A76ED395 ON tennis_player_availability');
        $this->addSql('ALTER TABLE tennis_player_availability DROP user_id');
    }
}
