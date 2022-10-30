<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028035703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD business_street VARCHAR(255) DEFAULT NULL, ADD business_city VARCHAR(255) DEFAULT NULL, ADD business_postal_code VARCHAR(255) DEFAULT NULL, ADD business_country VARCHAR(255) DEFAULT NULL, ADD home_street VARCHAR(255) DEFAULT NULL, ADD home_city VARCHAR(255) DEFAULT NULL, ADD home_postal_code VARCHAR(255) DEFAULT NULL, ADD home_country VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP business_street, DROP business_city, DROP business_postal_code, DROP business_country, DROP home_street, DROP home_city, DROP home_postal_code, DROP home_country');
    }
}
