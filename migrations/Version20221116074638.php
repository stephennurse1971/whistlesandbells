<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116074638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE introduction_segment ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE introduction_segment ADD CONSTRAINT FK_46BB6A3DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_46BB6A3DA76ED395 ON introduction_segment (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE introduction_segment DROP FOREIGN KEY FK_46BB6A3DA76ED395');
        $this->addSql('DROP INDEX IDX_46BB6A3DA76ED395 ON introduction_segment');
        $this->addSql('ALTER TABLE introduction_segment DROP user_id');
    }
}
