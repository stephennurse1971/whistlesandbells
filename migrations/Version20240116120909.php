<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116120909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset_classes DROP show_tax_year_details, DROP show_share_prices');
        $this->addSql('ALTER TABLE tax_schemes ADD show_in_tax_return TINYINT(1) DEFAULT NULL, ADD show_share_prices TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset_classes ADD show_tax_year_details TINYINT(1) DEFAULT NULL, ADD show_share_prices TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE tax_schemes DROP show_in_tax_return, DROP show_share_prices');
    }
}
