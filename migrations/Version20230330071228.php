<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330071228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_inputs ADD year_id INT NOT NULL');
        $this->addSql('ALTER TABLE tax_inputs ADD CONSTRAINT FK_4FBBCAE540C1FEA7 FOREIGN KEY (year_id) REFERENCES tax_year (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBBCAE540C1FEA7 ON tax_inputs (year_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_inputs DROP FOREIGN KEY FK_4FBBCAE540C1FEA7');
        $this->addSql('DROP INDEX UNIQ_4FBBCAE540C1FEA7 ON tax_inputs');
        $this->addSql('ALTER TABLE tax_inputs DROP year_id');
    }
}
