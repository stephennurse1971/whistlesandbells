<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210710145815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_bookings ADD player2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tennis_bookings ADD CONSTRAINT FK_E250CF49D22CABCD FOREIGN KEY (player2_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E250CF49D22CABCD ON tennis_bookings (player2_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tennis_bookings DROP FOREIGN KEY FK_E250CF49D22CABCD');
        $this->addSql('DROP INDEX IDX_E250CF49D22CABCD ON tennis_bookings');
        $this->addSql('ALTER TABLE tennis_bookings DROP player2_id');
    }
}
