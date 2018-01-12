<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180112185324 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE registry_entries (id SERIAL NOT NULL, transaction_id INT DEFAULT NULL, user_id INT DEFAULT NULL, account_id INT DEFAULT NULL, debet_amount DOUBLE PRECISION DEFAULT \'0\' NOT NULL, credit_amount DOUBLE PRECISION DEFAULT \'0\' NOT NULL, comment VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AB30C972FC0CB0F ON registry_entries (transaction_id)');
        $this->addSql('CREATE INDEX IDX_2AB30C97A76ED395 ON registry_entries (user_id)');
        $this->addSql('CREATE INDEX IDX_2AB30C979B6B5FBA ON registry_entries (account_id)');
        $this->addSql('CREATE UNIQUE INDEX registry_entry_unique ON registry_entries (transaction_id, user_id, account_id, debet_amount, credit_amount)');
        $this->addSql('ALTER TABLE registry_entries ADD CONSTRAINT FK_2AB30C972FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transactions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE registry_entries ADD CONSTRAINT FK_2AB30C97A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE registry_entries ADD CONSTRAINT FK_2AB30C979B6B5FBA FOREIGN KEY (account_id) REFERENCES accounts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE registry_entries');
    }
}
