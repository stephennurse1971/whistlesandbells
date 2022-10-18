<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920114928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_year DROP FOREIGN KEY FK_A70D7CCFBC215702');
        $this->addSql('DROP INDEX IDX_A70D7CCFBC215702 ON tax_year');
        $this->addSql('ALTER TABLE tax_year DROP uk_day_id, DROP days');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_year ADD uk_day_id INT NOT NULL, ADD days INT NOT NULL');
        $this->addSql('ALTER TABLE tax_year ADD CONSTRAINT FK_A70D7CCFBC215702 FOREIGN KEY (uk_day_id) REFERENCES uk_days (id)');
        $this->addSql('CREATE INDEX IDX_A70D7CCFBC215702 ON tax_year (uk_day_id)');
    }
}
