<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530053906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos ADD uploaded_by_id INT DEFAULT NULL, ADD date DATE DEFAULT NULL, ADD `high_priority` TINYINT(1) DEFAULT NULL, ADD email TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9A2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_876E0D9A2B28FE8 ON photos (uploaded_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9A2B28FE8');
        $this->addSql('DROP INDEX IDX_876E0D9A2B28FE8 ON photos');
        $this->addSql('ALTER TABLE photos DROP uploaded_by_id, DROP date, DROP `high_priority`, DROP email');
    }
}
