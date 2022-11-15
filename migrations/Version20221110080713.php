<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110080713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prospect_employer ADD interviewer1_id INT DEFAULT NULL, ADD interviewer2_id INT DEFAULT NULL, ADD interviewer3_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospect_employer ADD CONSTRAINT FK_5F31AABB78C44100 FOREIGN KEY (interviewer1_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prospect_employer ADD CONSTRAINT FK_5F31AABB6A71EEEE FOREIGN KEY (interviewer2_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prospect_employer ADD CONSTRAINT FK_5F31AABBD2CD898B FOREIGN KEY (interviewer3_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5F31AABB78C44100 ON prospect_employer (interviewer1_id)');
        $this->addSql('CREATE INDEX IDX_5F31AABB6A71EEEE ON prospect_employer (interviewer2_id)');
        $this->addSql('CREATE INDEX IDX_5F31AABBD2CD898B ON prospect_employer (interviewer3_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prospect_employer DROP FOREIGN KEY FK_5F31AABB78C44100');
        $this->addSql('ALTER TABLE prospect_employer DROP FOREIGN KEY FK_5F31AABB6A71EEEE');
        $this->addSql('ALTER TABLE prospect_employer DROP FOREIGN KEY FK_5F31AABBD2CD898B');
        $this->addSql('DROP INDEX IDX_5F31AABB78C44100 ON prospect_employer');
        $this->addSql('DROP INDEX IDX_5F31AABB6A71EEEE ON prospect_employer');
        $this->addSql('DROP INDEX IDX_5F31AABBD2CD898B ON prospect_employer');
        $this->addSql('ALTER TABLE prospect_employer DROP interviewer1_id, DROP interviewer2_id, DROP interviewer3_id');
    }
}
