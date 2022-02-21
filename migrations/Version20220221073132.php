<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221073132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investment_future_comms ADD market_data_id INT NOT NULL');
        $this->addSql('ALTER TABLE investment_future_comms ADD CONSTRAINT FK_D71F15303E6349BC FOREIGN KEY (market_data_id) REFERENCES market_data (id)');
        $this->addSql('CREATE INDEX IDX_D71F15303E6349BC ON investment_future_comms (market_data_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE investment_future_comms DROP FOREIGN KEY FK_D71F15303E6349BC');
        $this->addSql('DROP INDEX IDX_D71F15303E6349BC ON investment_future_comms');
        $this->addSql('ALTER TABLE investment_future_comms DROP market_data_id');
    }
}
