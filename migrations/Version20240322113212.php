<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322113212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE facebook_reviews');
        $this->addSql('ALTER TABLE Photos ADD favourites_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Photos ADD CONSTRAINT FK_876E0D94F6A19D0 FOREIGN KEY (favourites_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_876E0D94F6A19D0 ON Photos (favourites_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facebook_reviews (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE Photos DROP FOREIGN KEY FK_876E0D94F6A19D0');
        $this->addSql('DROP INDEX IDX_876E0D94F6A19D0 ON Photos');
        $this->addSql('ALTER TABLE Photos DROP favourites_id');
    }
}
