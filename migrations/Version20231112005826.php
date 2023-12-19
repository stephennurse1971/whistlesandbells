<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231112005826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE to_do_list_user (to_do_list_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_217390F1B3AB48EB (to_do_list_id), INDEX IDX_217390F1A76ED395 (user_id), PRIMARY KEY(to_do_list_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE to_do_list_user ADD CONSTRAINT FK_217390F1B3AB48EB FOREIGN KEY (to_do_list_id) REFERENCES to_do_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE to_do_list_user ADD CONSTRAINT FK_217390F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE to_do_list ADD project VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE to_do_list_user');
        $this->addSql('ALTER TABLE to_do_list DROP project');
    }
}
