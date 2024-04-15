<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415124718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE facebook_reviews');
        $this->addSql('ALTER TABLE flight_destinations ADD departure_city_id INT DEFAULT NULL, ADD arrival_city_id INT DEFAULT NULL, DROP departure_city, DROP departure_code, DROP arrival_city, DROP arrival_code');
        $this->addSql('ALTER TABLE flight_destinations ADD CONSTRAINT FK_7E99DE9918B251E FOREIGN KEY (departure_city_id) REFERENCES airports (id)');
        $this->addSql('ALTER TABLE flight_destinations ADD CONSTRAINT FK_7E99DE94067ACA7 FOREIGN KEY (arrival_city_id) REFERENCES airports (id)');
        $this->addSql('CREATE INDEX IDX_7E99DE9918B251E ON flight_destinations (departure_city_id)');
        $this->addSql('CREATE INDEX IDX_7E99DE94067ACA7 ON flight_destinations (arrival_city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facebook_reviews (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE flight_destinations DROP FOREIGN KEY FK_7E99DE9918B251E');
        $this->addSql('ALTER TABLE flight_destinations DROP FOREIGN KEY FK_7E99DE94067ACA7');
        $this->addSql('DROP INDEX IDX_7E99DE9918B251E ON flight_destinations');
        $this->addSql('DROP INDEX IDX_7E99DE94067ACA7 ON flight_destinations');
        $this->addSql('ALTER TABLE flight_destinations ADD departure_city VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD departure_code VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD arrival_city VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD arrival_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP departure_city_id, DROP arrival_city_id');
    }
}
