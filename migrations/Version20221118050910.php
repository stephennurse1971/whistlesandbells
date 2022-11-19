<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221118050910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tourist_attraction (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, email2 VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, business_phone VARCHAR(255) DEFAULT NULL, web_page VARCHAR(255) DEFAULT NULL, notes VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, business_street VARCHAR(255) DEFAULT NULL, business_city VARCHAR(255) DEFAULT NULL, business_post_code VARCHAR(255) DEFAULT NULL, INDEX IDX_C46F906EF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tourist_attraction ADD CONSTRAINT FK_C46F906EF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tourist_attraction');
    }
}
