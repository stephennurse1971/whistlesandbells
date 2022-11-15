<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110080959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prospect_employer ADD applicant_id INT NOT NULL');
        $this->addSql('ALTER TABLE prospect_employer ADD CONSTRAINT FK_5F31AABB97139001 FOREIGN KEY (applicant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5F31AABB97139001 ON prospect_employer (applicant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prospect_employer DROP FOREIGN KEY FK_5F31AABB97139001');
        $this->addSql('DROP INDEX IDX_5F31AABB97139001 ON prospect_employer');
        $this->addSql('ALTER TABLE prospect_employer DROP applicant_id');
    }
}
