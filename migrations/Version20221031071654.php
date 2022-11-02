<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221031071654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recruiter_emails ADD send_to_full_name VARCHAR(255) DEFAULT NULL, ADD send_ccfull_name VARCHAR(255) DEFAULT NULL, ADD send_bcc_full_name VARCHAR(255) DEFAULT NULL, ADD author_full_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recruiter_emails DROP send_to_full_name, DROP send_ccfull_name, DROP send_bcc_full_name, DROP author_full_name');
    }
}
