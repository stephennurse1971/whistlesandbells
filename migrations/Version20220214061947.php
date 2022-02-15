<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214061947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE investment_future_comms (id INT AUTO_INCREMENT NOT NULL, investment_id INT NOT NULL, date DATE DEFAULT NULL, attachment VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_D71F15306E1B4FD5 (investment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE investment_future_comms ADD CONSTRAINT FK_D71F15306E1B4FD5 FOREIGN KEY (investment_id) REFERENCES investments (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE investment_future_comms');
    }
}
