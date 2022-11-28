<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126091059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_locations DROP FOREIGN KEY FK_1A181C9B43E1D12');
        $this->addSql('DROP INDEX IDX_1A181C9B43E1D12 ON photo_locations');
        $this->addSql('ALTER TABLE photo_locations ADD enabled_users JSON DEFAULT NULL, DROP enabled_users_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_locations ADD enabled_users_id INT DEFAULT NULL, DROP enabled_users');
        $this->addSql('ALTER TABLE photo_locations ADD CONSTRAINT FK_1A181C9B43E1D12 FOREIGN KEY (enabled_users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1A181C9B43E1D12 ON photo_locations (enabled_users_id)');
    }
}
