<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208072107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tax_supporting_docs (id INT AUTO_INCREMENT NOT NULL, tax_year_id INT NOT NULL, date DATE DEFAULT NULL, comments VARCHAR(255) DEFAULT NULL, attachment VARCHAR(255) DEFAULT NULL, INDEX IDX_37201FCD1895EAD (tax_year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tax_supporting_docs ADD CONSTRAINT FK_37201FCD1895EAD FOREIGN KEY (tax_year_id) REFERENCES tax_documents (id)');
        $this->addSql('ALTER TABLE investments CHANGE investment_eis investment_eis TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tax_supporting_docs');
        $this->addSql('ALTER TABLE investments CHANGE investment_eis investment_eis TINYINT(1) NOT NULL');
    }
}
