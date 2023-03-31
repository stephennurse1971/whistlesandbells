<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331093420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments ADD tax_scheme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE investments ADD CONSTRAINT FK_74FD72E049407248 FOREIGN KEY (tax_scheme_id) REFERENCES tax_schemes (id)');
        $this->addSql('CREATE INDEX IDX_74FD72E049407248 ON investments (tax_scheme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments DROP FOREIGN KEY FK_74FD72E049407248');
        $this->addSql('DROP INDEX IDX_74FD72E049407248 ON investments');
        $this->addSql('ALTER TABLE investments DROP tax_scheme_id');
    }
}
