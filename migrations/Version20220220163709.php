<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220163709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jpm_ic_history (id INT AUTO_INCREMENT NOT NULL, year DOUBLE PRECISION DEFAULT NULL, base_salary_gbp DOUBLE PRECISION DEFAULT NULL, total_comp_usd DOUBLE PRECISION DEFAULT NULL, ic_total DOUBLE PRECISION DEFAULT NULL, ic_cash DOUBLE PRECISION DEFAULT NULL, ic_shares DOUBLE PRECISION DEFAULT NULL, ic_share_price DOUBLE PRECISION DEFAULT NULL, ic_shares1 DOUBLE PRECISION DEFAULT NULL, ic_shares2 DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE jpm_ic_history');
    }
}
