<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210918200016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, wallet_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, status VARCHAR(10) NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_EAA81A4C712520F3 (wallet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transfers (id INT NOT NULL, payee_id INT DEFAULT NULL, wallet_received_id INT DEFAULT NULL, INDEX IDX_802A3918CB4B68F (payee_id), INDEX IDX_802A3918CDCC1956 (wallet_received_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deposits (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C712520F3 FOREIGN KEY (wallet_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE transfers ADD CONSTRAINT FK_802A3918CB4B68F FOREIGN KEY (payee_id) REFERENCES person_users (id)');
        $this->addSql('ALTER TABLE transfers ADD CONSTRAINT FK_802A3918CDCC1956 FOREIGN KEY (wallet_received_id) REFERENCES wallets (id)');
        $this->addSql('ALTER TABLE transfers ADD CONSTRAINT FK_802A3918BF396750 FOREIGN KEY (id) REFERENCES transactions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deposits ADD CONSTRAINT FK_449E9C9EBF396750 FOREIGN KEY (id) REFERENCES transactions (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transfers DROP FOREIGN KEY FK_802A3918BF396750');
        $this->addSql('ALTER TABLE deposits DROP FOREIGN KEY FK_449E9C9EBF396750');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE transfers');
        $this->addSql('DROP TABLE deposits');
    }
}
