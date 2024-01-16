<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116124128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments DROP FOREIGN KEY FK_74FD72E049407248');
        $this->addSql('DROP INDEX IDX_74FD72E049407248 ON investments');
        $this->addSql('ALTER TABLE investments CHANGE tax_scheme_id asset_class_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE investments ADD CONSTRAINT FK_74FD72E0686B1190 FOREIGN KEY (asset_class_id) REFERENCES asset_classes (id)');
        $this->addSql('CREATE INDEX IDX_74FD72E0686B1190 ON investments (asset_class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments DROP FOREIGN KEY FK_74FD72E0686B1190');
        $this->addSql('DROP INDEX IDX_74FD72E0686B1190 ON investments');
        $this->addSql('ALTER TABLE investments CHANGE asset_class_id tax_scheme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE investments ADD CONSTRAINT FK_74FD72E049407248 FOREIGN KEY (tax_scheme_id) REFERENCES tax_schemes (id)');
        $this->addSql('CREATE INDEX IDX_74FD72E049407248 ON investments (tax_scheme_id)');
    }
}
