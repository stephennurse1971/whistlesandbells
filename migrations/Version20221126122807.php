<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126122807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photos_user');
        $this->addSql('ALTER TABLE photos DROP date, DROP public, DROP description');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photos_user (photos_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1A8964A8301EC62 (photos_id), INDEX IDX_1A8964A8A76ED395 (user_id), PRIMARY KEY(photos_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE photos_user ADD CONSTRAINT FK_1A8964A8301EC62 FOREIGN KEY (photos_id) REFERENCES photos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photos_user ADD CONSTRAINT FK_1A8964A8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photos ADD date DATE DEFAULT NULL, ADD public TINYINT(1) DEFAULT NULL, ADD description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
