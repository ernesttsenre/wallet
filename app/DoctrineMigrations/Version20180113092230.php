<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180113092230 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP INDEX registry_entry_unique');
        $this->addSql('ALTER TABLE registry_entries RENAME COLUMN debet_amount TO debit_amount');
        $this->addSql('CREATE UNIQUE INDEX registry_entry_unique ON registry_entries (transaction_id, user_id, account_id, debit_amount, credit_amount)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX registry_entry_unique');
        $this->addSql('ALTER TABLE registry_entries RENAME COLUMN debit_amount TO debet_amount');
        $this->addSql('CREATE UNIQUE INDEX registry_entry_unique ON registry_entries (transaction_id, user_id, account_id, debet_amount, credit_amount)');
    }
}
