<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210710144551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player2 (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tennis_bookings ADD player3_id INT DEFAULT NULL, ADD player4_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF496A90CCA8 FOREIGN KEY (player3_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF49F747F411 FOREIGN KEY (player4_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E250CF496A90CCA8 ON tennis_bookings (player3_id)');
        $this->addSql('CREATE INDEX IDX_E250CF49F747F411 ON tennis_bookings (player4_id)');
        $this->addSql('ALTER TABLE user ADD tennisbookings2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64934B8A428 FOREIGN KEY (tennisbookings2_id) REFERENCES tennis_bookings (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64934B8A428 ON user (tennisbookings2_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE player2');
        $this->addSql('ALTER TABLE tennis_bookings DROP FOREIGN KEY FK_E250CF496A90CCA8');
        $this->addSql('ALTER TABLE tennis_bookings DROP FOREIGN KEY FK_E250CF49F747F411');
        $this->addSql('DROP INDEX IDX_E250CF496A90CCA8 ON tennis_bookings');
        $this->addSql('DROP INDEX IDX_E250CF49F747F411 ON tennis_bookings');
        $this->addSql('ALTER TABLE tennis_bookings DROP player3_id, DROP player4_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64934B8A428');
        $this->addSql('DROP INDEX IDX_8D93D64934B8A428 ON user');
        $this->addSql('ALTER TABLE user DROP tennisbookings2_id');
    }
}
