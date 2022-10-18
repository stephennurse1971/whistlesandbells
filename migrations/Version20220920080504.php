<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920080504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE uk_days ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE uk_days ADD CONSTRAINT FK_31ECA40BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_31ECA40BF92F3E70 ON uk_days (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE uk_days DROP FOREIGN KEY FK_31ECA40BF92F3E70');
        $this->addSql('DROP INDEX IDX_31ECA40BF92F3E70 ON uk_days');
        $this->addSql('ALTER TABLE uk_days DROP country_id');
    }
}
