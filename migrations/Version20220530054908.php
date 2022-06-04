<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530054908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE house_guests (id INT AUTO_INCREMENT NOT NULL, guest_name_id INT NOT NULL, date DATE DEFAULT NULL, room_count INT NOT NULL, notes VARCHAR(255) DEFAULT NULL, INDEX IDX_FEAC253B31D2589A (guest_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE house_guests ADD CONSTRAINT FK_FEAC253B31D2589A FOREIGN KEY (guest_name_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE house_guests');
    }
}
