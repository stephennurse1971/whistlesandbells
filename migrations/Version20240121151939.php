<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121151939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bank_balances (id INT AUTO_INCREMENT NOT NULL, bank_id INT DEFAULT NULL, date DATE DEFAULT NULL, balance_gbp DOUBLE PRECISION DEFAULT NULL, balance_usd DOUBLE PRECISION DEFAULT NULL, balance_eur DOUBLE PRECISION DEFAULT NULL, balance_chf DOUBLE PRECISION DEFAULT NULL, INDEX IDX_70E7FE8811C8FB41 (bank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bank_balances ADD CONSTRAINT FK_70E7FE8811C8FB41 FOREIGN KEY (bank_id) REFERENCES bank_accounts (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bank_balances');
    }
}
