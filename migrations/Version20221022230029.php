<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221022230029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prospect_employer (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT DEFAULT NULL, employer VARCHAR(255) NOT NULL, interview_date1 DATE DEFAULT NULL, interview_date2 DATE DEFAULT NULL, interview_date3 DATE DEFAULT NULL, INDEX IDX_5F31AABB156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prospect_employer ADD CONSTRAINT FK_5F31AABB156BE243 FOREIGN KEY (recruiter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD prospect_employer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AA7C80C7 FOREIGN KEY (prospect_employer_id) REFERENCES prospect_employer (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AA7C80C7 ON user (prospect_employer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AA7C80C7');
        $this->addSql('DROP TABLE prospect_employer');
        $this->addSql('DROP INDEX IDX_8D93D649AA7C80C7 ON user');
        $this->addSql('ALTER TABLE user DROP prospect_employer_id');
    }
}
