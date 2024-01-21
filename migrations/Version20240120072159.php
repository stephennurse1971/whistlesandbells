<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120072159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE market_data_history (id INT AUTO_INCREMENT NOT NULL, security_id INT DEFAULT NULL, date DATE DEFAULT NULL, market_price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C9C080F46DBE4214 (security_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE market_data_history ADD CONSTRAINT FK_C9C080F46DBE4214 FOREIGN KEY (security_id) REFERENCES market_data (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE market_data_history');
    }
}
