<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215071527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments DROP FOREIGN KEY FK_74FD72E0CDD562F6');
        $this->addSql('DROP INDEX IDX_74FD72E0CDD562F6 ON investments');
        $this->addSql('ALTER TABLE investments CHANGE eissale_year_id eissale_year1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE investments ADD CONSTRAINT FK_74FD72E0827FAFD8 FOREIGN KEY (eissale_year1_id) REFERENCES tax_documents (id)');
        $this->addSql('CREATE INDEX IDX_74FD72E0827FAFD8 ON investments (eissale_year1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments DROP FOREIGN KEY FK_74FD72E0827FAFD8');
        $this->addSql('DROP INDEX IDX_74FD72E0827FAFD8 ON investments');
        $this->addSql('ALTER TABLE investments CHANGE eissale_year1_id eissale_year_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE investments ADD CONSTRAINT FK_74FD72E0CDD562F6 FOREIGN KEY (eissale_year_id) REFERENCES tax_documents (id)');
        $this->addSql('CREATE INDEX IDX_74FD72E0CDD562F6 ON investments (eissale_year_id)');
    }
}
