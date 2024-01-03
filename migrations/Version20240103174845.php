<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240103174845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flight_destinations ADD date_start DATE DEFAULT NULL, ADD date_end DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE health ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE health ADD CONSTRAINT FK_CEDA2313A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CEDA2313A76ED395 ON health (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flight_destinations DROP date_start, DROP date_end');
        $this->addSql('ALTER TABLE health DROP FOREIGN KEY FK_CEDA2313A76ED395');
        $this->addSql('DROP INDEX IDX_CEDA2313A76ED395 ON health');
        $this->addSql('ALTER TABLE health DROP user_id');
    }
}
