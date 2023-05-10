<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507183103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments ADD eis_purchase_year1_self_assessment_check VARCHAR(255) DEFAULT NULL, ADD eis_purchase_year2_self_assessment_check VARCHAR(255) DEFAULT NULL, ADD eis_sale_year1_self_assessment_check VARCHAR(255) DEFAULT NULL, ADD eis_sale_year2_self_assessment_check VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investments DROP eis_purchase_year1_self_assessment_check, DROP eis_purchase_year2_self_assessment_check, DROP eis_sale_year1_self_assessment_check, DROP eis_sale_year2_self_assessment_check');
    }
}
