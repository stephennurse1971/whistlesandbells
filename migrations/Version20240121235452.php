<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121235452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset_classes ADD include_in_standard_investment_form TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE market_data DROP asset_sold');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asset_classes DROP include_in_standard_investment_form');
        $this->addSql('ALTER TABLE market_data ADD asset_sold TINYINT(1) DEFAULT NULL');
    }
}
