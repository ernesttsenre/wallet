<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180112180758 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
            CREATE FUNCTION manage_registry_entries() RETURNS trigger AS $emp_stamp$
                BEGIN
                    -- transaction_id, user_id, account_id, debet_amount, credit_amount, comment, created_at
                    IF (TG_OP = \'INSERT\') THEN
                        INSERT INTO registry_entries VALUES (default, NEW.id, NEW.user_id, NEW.reciever_account_id, NEW.amount, 0, NEW.comment, NEW.created_at);
                        INSERT INTO registry_entries VALUES (default, NEW.id, NEW.user_id, NEW.source_account_id, 0, NEW.amount, NEW.comment, NEW.created_at);
                        RETURN NEW;
                    ELSIF (TG_OP = \'UPDATE\') THEN
                        DELETE FROM registry_entries WHERE transaction_id = OLD.id;
                        INSERT INTO registry_entries VALUES (default, NEW.id, NEW.user_id, NEW.reciever_account_id, NEW.amount, 0, NEW.comment, NEW.created_at);
                        INSERT INTO registry_entries VALUES (default, NEW.id, NEW.user_id, NEW.source_account_id, 0, NEW.amount, NEW.comment, NEW.created_at);
                        RETURN NEW;
                    ELSIF (TG_OP = \'DELETE\') THEN
                        DELETE FROM registry_entries WHERE transaction_id = OLD.id;
                        RETURN OLD;
                    END IF;
                    RETURN NULL;
                END;
            $emp_stamp$ LANGUAGE plpgsql;
        ');

        $this->addSql('
            CREATE TRIGGER manage_registry_entries_trigger AFTER INSERT OR UPDATE OR DELETE ON transactions FOR EACH ROW EXECUTE PROCEDURE manage_registry_entries();
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TRIGGER manage_registry_entries_trigger ON transactions;');

        $this->addSql('DROP FUNCTION manage_registry_entries();');
    }
}
