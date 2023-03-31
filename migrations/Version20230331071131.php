<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331071131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_supporting_docs DROP FOREIGN KEY FK_37201FCD1895EAD');
        $this->addSql('DROP INDEX IDX_37201FCD1895EAD ON tax_supporting_docs');
        $this->addSql('ALTER TABLE tax_supporting_docs DROP tax_year_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tax_supporting_docs ADD tax_year_id INT NOT NULL');
        $this->addSql('ALTER TABLE tax_supporting_docs ADD CONSTRAINT FK_37201FCD1895EAD FOREIGN KEY (tax_year_id) REFERENCES tax_documents (id)');
        $this->addSql('CREATE INDEX IDX_37201FCD1895EAD ON tax_supporting_docs (tax_year_id)');
    }
}
