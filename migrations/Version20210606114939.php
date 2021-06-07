<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210606114939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tennis_availability');
        $this->addSql('DROP TABLE tennis_player_appetite');
        $this->addSql('ALTER TABLE tennis_player_availability ADD hour INT DEFAULT NULL, DROP time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tennis_availability (id INT AUTO_INCREMENT NOT NULL, venue_id INT NOT NULL, hour INT NOT NULL, available VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, INDEX IDX_AB475A3E40A73EBA (venue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tennis_player_appetite (id INT AUTO_INCREMENT NOT NULL, tennis_player_id INT NOT NULL, date DATE NOT NULL, time INT NOT NULL, INDEX IDX_9DD31DB0C0CD1D3B (tennis_player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tennis_availability ADD CONSTRAINT FK_AB475A3E40A73EBA FOREIGN KEY (venue_id) REFERENCES tennis_venues (id)');
        $this->addSql('ALTER TABLE tennis_player_appetite ADD CONSTRAINT FK_9DD31DB0C0CD1D3B FOREIGN KEY (tennis_player_id) REFERENCES tennis_players (id)');
        $this->addSql('ALTER TABLE tennis_player_availability ADD time INT NOT NULL, DROP hour');
    }
}
