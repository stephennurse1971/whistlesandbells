<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720064454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tax_year (id INT AUTO_INCREMENT NOT NULL, uk_day_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, days INT NOT NULL, INDEX IDX_A70D7CCFBC215702 (uk_day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tax_year ADD CONSTRAINT FK_A70D7CCFBC215702 FOREIGN KEY (uk_day_id) REFERENCES uk_days (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tax_year');
    }
}
