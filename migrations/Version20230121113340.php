<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230121113340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64995AEA86D');
        $this->addSql('DROP TABLE tennis_group_session');
        $this->addSql('DROP TABLE tennis_venues');
        $this->addSql('DROP INDEX IDX_8D93D64995AEA86D ON user');
        $this->addSql('ALTER TABLE user DROP tennis_venues_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tennis_group_session (id INT AUTO_INCREMENT NOT NULL, session_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, max_players INT DEFAULT NULL, min_players INT DEFAULT NULL, gender_split VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, dayof_week VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, start_time TIME DEFAULT NULL, end_time TIME DEFAULT NULL, courts INT DEFAULT NULL, price_per_person INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tennis_venues (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user ADD tennis_venues_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64995AEA86D FOREIGN KEY (tennis_venues_id) REFERENCES tennis_venues (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64995AEA86D ON user (tennis_venues_id)');
    }
}
