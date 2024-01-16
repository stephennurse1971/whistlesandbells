<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116113826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset_classes ADD tax_scheme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asset_classes ADD CONSTRAINT FK_61033F9349407248 FOREIGN KEY (tax_scheme_id) REFERENCES tax_schemes (id)');
        $this->addSql('CREATE INDEX IDX_61033F9349407248 ON asset_classes (tax_scheme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset_classes DROP FOREIGN KEY FK_61033F9349407248');
        $this->addSql('DROP INDEX IDX_61033F9349407248 ON asset_classes');
        $this->addSql('ALTER TABLE asset_classes DROP tax_scheme_id');
    }
}
