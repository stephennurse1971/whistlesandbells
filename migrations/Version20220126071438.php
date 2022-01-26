<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126071438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE investments (id INT AUTO_INCREMENT NOT NULL, investment_name VARCHAR(255) NOT NULL, investment_date DATE DEFAULT NULL, investment_amount DOUBLE PRECISION DEFAULT NULL, investment_eis TINYINT(1) NOT NULL, investment_sold_price DOUBLE PRECISION DEFAULT NULL, investment_sale_date DATE DEFAULT NULL, share_cert VARCHAR(255) DEFAULT NULL, eis_cert VARCHAR(255) DEFAULT NULL, other_docs VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE investments');
    }
}
