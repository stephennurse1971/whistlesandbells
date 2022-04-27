<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427055601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_bookings DROP FOREIGN KEY FK_E250CF4940A73EBA');
        $this->addSql('ALTER TABLE tennis_court_availability DROP FOREIGN KEY FK_AB475A3E40A73EBA');
        $this->addSql('ALTER TABLE tennis_court_preferences DROP FOREIGN KEY FK_B9485B97D872CDC6');
        $this->addSql('DROP TABLE credit_card_details');
        $this->addSql('DROP TABLE default_tennis_player_availability_hours');
        $this->addSql('DROP TABLE tennis_bookings');
        $this->addSql('DROP TABLE tennis_court_availability');
        $this->addSql('DROP TABLE tennis_court_preferences');
        $this->addSql('DROP TABLE tennis_player_availability');
        $this->addSql('DROP TABLE tennis_venues');
        $this->addSql('ALTER TABLE user DROP tennis_rank, DROP tennis_rank_score');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE credit_card_details (id INT AUTO_INCREMENT NOT NULL, cardholder_id INT NOT NULL, card_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, card_expiry VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, card_cvc VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, th_login VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, th_password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, card_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address1 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, town VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, county VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, post_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, card_expiry2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_3C99BB6491FE933 (cardholder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE default_tennis_player_availability_hours (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, weekday_or_weekend VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hour INT DEFAULT NULL, default_available TINYINT(1) DEFAULT NULL, INDEX IDX_869F38CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tennis_bookings (id INT AUTO_INCREMENT NOT NULL, venue_id INT NOT NULL, player1_id INT DEFAULT NULL, player3_id INT DEFAULT NULL, player4_id INT DEFAULT NULL, player2_id INT DEFAULT NULL, date DATETIME NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, number_of_players INT DEFAULT NULL, INDEX IDX_E250CF49F747F411 (player4_id), INDEX IDX_E250CF49C0990423 (player1_id), INDEX IDX_E250CF496A90CCA8 (player3_id), INDEX IDX_E250CF49D22CABCD (player2_id), INDEX IDX_E250CF4940A73EBA (venue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tennis_court_availability (id INT AUTO_INCREMENT NOT NULL, venue_id INT NOT NULL, hour INT NOT NULL, available VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, court_booked TINYINT(1) DEFAULT NULL, court_cost DOUBLE PRECISION DEFAULT NULL, INDEX IDX_AB475A3E40A73EBA (venue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tennis_court_preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, tennis_venue_id INT DEFAULT NULL, weekday_election TINYINT(1) DEFAULT NULL, weekend_election TINYINT(1) DEFAULT NULL, INDEX IDX_B9485B97D872CDC6 (tennis_venue_id), INDEX IDX_B9485B97A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tennis_player_availability (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date DATE NOT NULL, hour INT NOT NULL, available TINYINT(1) DEFAULT NULL, INDEX IDX_123CAE01A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tennis_venues (id INT AUTO_INCREMENT NOT NULL, venue VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, address VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, map_link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, comment VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, web_link VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tel_number VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, booking_engine VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, london_region VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tower_hamlets_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, is_active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE credit_card_details ADD CONSTRAINT FK_3C99BB6491FE933 FOREIGN KEY (cardholder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE default_tennis_player_availability_hours ADD CONSTRAINT FK_869F38CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF4940A73EBA FOREIGN KEY (venue_id) REFERENCES tennis_venues (id)');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF496A90CCA8 FOREIGN KEY (player3_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF49C0990423 FOREIGN KEY (player1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF49D22CABCD FOREIGN KEY (player2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF49F747F411 FOREIGN KEY (player4_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_court_availability ADD CONSTRAINT FK_AB475A3E40A73EBA FOREIGN KEY (venue_id) REFERENCES tennis_venues (id)');
        $this->addSql('ALTER TABLE tennis_court_preferences ADD CONSTRAINT FK_B9485B97A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tennis_court_preferences ADD CONSTRAINT FK_B9485B97D872CDC6 FOREIGN KEY (tennis_venue_id) REFERENCES tennis_venues (id)');
        $this->addSql('ALTER TABLE tennis_player_availability ADD CONSTRAINT FK_123CAE01A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD tennis_rank INT DEFAULT NULL, ADD tennis_rank_score INT DEFAULT NULL');
    }
}
