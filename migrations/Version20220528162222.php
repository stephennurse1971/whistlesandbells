<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528162222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE static_text ADD mobile_number VARCHAR(255) DEFAULT NULL, ADD email_address VARCHAR(255) DEFAULT NULL, ADD facebook_link VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD gps_coordinates VARCHAR(255) DEFAULT NULL, ADD companies_house_link VARCHAR(255) DEFAULT NULL, ADD linked_in VARCHAR(255) DEFAULT NULL, ADD github VARCHAR(255) DEFAULT NULL, ADD twitter VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE static_text DROP mobile_number, DROP email_address, DROP facebook_link, DROP address, DROP gps_coordinates, DROP companies_house_link, DROP linked_in, DROP github, DROP twitter');
    }
}
