<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210724131337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_card_details ADD th_login VARCHAR(255) NOT NULL, ADD th_password VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD card_type VARCHAR(255) NOT NULL, ADD address1 VARCHAR(255) NOT NULL, ADD address2 VARCHAR(255) NOT NULL, ADD town VARCHAR(255) NOT NULL, ADD county VARCHAR(255) NOT NULL, ADD post_code VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_card_details DROP th_login, DROP th_password, DROP first_name, DROP last_name, DROP card_type, DROP address1, DROP address2, DROP town, DROP county, DROP post_code, DROP telephone');
    }
}
