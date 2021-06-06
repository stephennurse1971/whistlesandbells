<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602220026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE credit_card_details (id INT AUTO_INCREMENT NOT NULL, cardholder_id INT NOT NULL, card_number VARCHAR(255) DEFAULT NULL, card_expiry VARCHAR(255) DEFAULT NULL, card_cvc VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3C99BB6491FE933 (cardholder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE credit_card_details ADD CONSTRAINT FK_3C99BB6491FE933 FOREIGN KEY (cardholder_id) REFERENCES tennis_players (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE credit_card_details');
    }
}
