<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330071943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_year ADD tax_band1_rate DOUBLE PRECISION DEFAULT NULL, ADD tax_band2_rate DOUBLE PRECISION DEFAULT NULL, ADD tax_band3_rate DOUBLE PRECISION DEFAULT NULL, ADD tax_band4_rate DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_year DROP tax_band1_rate, DROP tax_band2_rate, DROP tax_band3_rate, DROP tax_band4_rate');
    }
}
