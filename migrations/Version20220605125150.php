<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605125150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD company VARCHAR(255) DEFAULT NULL, ADD business_address VARCHAR(255) DEFAULT NULL, ADD home_address VARCHAR(255) DEFAULT NULL, ADD business_phone VARCHAR(255) DEFAULT NULL, ADD home_phone VARCHAR(255) DEFAULT NULL, ADD home_phone2 VARCHAR(255) DEFAULT NULL, ADD birthday DATE DEFAULT NULL, ADD email3 VARCHAR(255) DEFAULT NULL, ADD web_page VARCHAR(255) DEFAULT NULL, ADD notes VARCHAR(255) DEFAULT NULL, ADD invite_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP company, DROP business_address, DROP home_address, DROP business_phone, DROP home_phone, DROP home_phone2, DROP birthday, DROP email3, DROP web_page, DROP notes, DROP invite_date');
    }
}
