<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210612082251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_card_details DROP FOREIGN KEY FK_3C99BB6491FE933');
        $this->addSql('ALTER TABLE credit_card_details ADD CONSTRAINT FK_3C99BB6491FE933 FOREIGN KEY (cardholder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD plain_password VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_card_details DROP FOREIGN KEY FK_3C99BB6491FE933');
        $this->addSql('ALTER TABLE credit_card_details ADD CONSTRAINT FK_3C99BB6491FE933 FOREIGN KEY (cardholder_id) REFERENCES tennis_players (id)');
        $this->addSql('ALTER TABLE user DROP plain_password');
    }
}
