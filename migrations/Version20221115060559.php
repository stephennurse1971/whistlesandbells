<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115060559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garmin_files (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, gpx_file VARCHAR(255) DEFAULT NULL, kilometres INT DEFAULT NULL, climb INT DEFAULT NULL, starting_point VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_C037B808F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garmin_files ADD CONSTRAINT FK_C037B808F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE uk_days CHANGE travel_docs2 travel_docs2 JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE garmin_files');
        $this->addSql('ALTER TABLE uk_days CHANGE travel_docs2 travel_docs2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
