<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111072245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE file_attachments DROP vendor, DROP amount, DROP serpentime_comments, DROP hmrc_comments, DROP receipt, DROP cash_or_debit, DROP barclays, DROP caxton');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs


        $this->addSql('ALTER TABLE file_attachments ADD vendor VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD amount DOUBLE PRECISION DEFAULT NULL, ADD serpentime_comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD hmrc_comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD receipt VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD cash_or_debit VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD barclays DOUBLE PRECISION DEFAULT NULL, ADD caxton DOUBLE PRECISION DEFAULT NULL');
    }
}
