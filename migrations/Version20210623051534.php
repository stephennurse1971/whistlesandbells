<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623051534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tennis_court_preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, tennis_venue_id INT DEFAULT NULL, INDEX IDX_B9485B97A76ED395 (user_id), INDEX IDX_B9485B97D872CDC6 (tennis_venue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tennis_court_preferences ADD CONSTRAINT FK_B9485B97A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_court_preferences ADD CONSTRAINT FK_B9485B97D872CDC6 FOREIGN KEY (tennis_venue_id) REFERENCES tennis_venues (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tennis_court_preferences');
    }
}
