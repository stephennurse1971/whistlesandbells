<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220217062558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments ADD investment_company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE investments ADD CONSTRAINT FK_74FD72E08EE31447 FOREIGN KEY (investment_company_id) REFERENCES market_data (id)');
        $this->addSql('CREATE INDEX IDX_74FD72E08EE31447 ON investments (investment_company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments DROP FOREIGN KEY FK_74FD72E08EE31447');
        $this->addSql('DROP INDEX IDX_74FD72E08EE31447 ON investments');
        $this->addSql('ALTER TABLE investments DROP investment_company_id');
    }
}
