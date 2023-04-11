<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411061545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE market_data ADD asset_class_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_data ADD CONSTRAINT FK_E2FF0AD3686B1190 FOREIGN KEY (asset_class_id) REFERENCES asset_classes (id)');
        $this->addSql('CREATE INDEX IDX_E2FF0AD3686B1190 ON market_data (asset_class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE market_data DROP FOREIGN KEY FK_E2FF0AD3686B1190');
        $this->addSql('DROP INDEX IDX_E2FF0AD3686B1190 ON market_data');
        $this->addSql('ALTER TABLE market_data DROP asset_class_id');
    }
}
