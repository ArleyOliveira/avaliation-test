<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210918210117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transfers DROP FOREIGN KEY FK_802A3918CDCC1956');
        $this->addSql('DROP INDEX IDX_802A3918CDCC1956 ON transfers');
        $this->addSql('ALTER TABLE transfers DROP wallet_received_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transfers ADD wallet_received_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transfers ADD CONSTRAINT FK_802A3918CDCC1956 FOREIGN KEY (wallet_received_id) REFERENCES wallets (id)');
        $this->addSql('CREATE INDEX IDX_802A3918CDCC1956 ON transfers (wallet_received_id)');
    }
}
