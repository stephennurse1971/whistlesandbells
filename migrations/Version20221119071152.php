<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221119071152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE static_text ADD photo1 VARCHAR(255) DEFAULT NULL, ADD photo2 VARCHAR(255) DEFAULT NULL, ADD photo3 VARCHAR(255) DEFAULT NULL, ADD photo4 VARCHAR(255) DEFAULT NULL, ADD photo5 VARCHAR(255) DEFAULT NULL, ADD photo6 VARCHAR(255) DEFAULT NULL, ADD photo7 VARCHAR(255) DEFAULT NULL, ADD photo8 VARCHAR(255) DEFAULT NULL, ADD photo9 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE static_text DROP photo1, DROP photo2, DROP photo3, DROP photo4, DROP photo5, DROP photo6, DROP photo7, DROP photo8, DROP photo9');
    }
}
