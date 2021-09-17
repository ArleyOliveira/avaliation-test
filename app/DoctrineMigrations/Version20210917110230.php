<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210917110230 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE person_users (id INT NOT NULL, nome VARCHAR(200) NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE physical_users (id INT NOT NULL, cpf VARCHAR(11) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legal_users (id INT NOT NULL, cnpj VARCHAR(14) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person_users ADD CONSTRAINT FK_B8B5BA2DBF396750 FOREIGN KEY (id) REFERENCES `users` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE physical_users ADD CONSTRAINT FK_8635B09FBF396750 FOREIGN KEY (id) REFERENCES `users` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE legal_users ADD CONSTRAINT FK_41ABF828BF396750 FOREIGN KEY (id) REFERENCES `users` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD type VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE person_users');
        $this->addSql('DROP TABLE physical_users');
        $this->addSql('DROP TABLE legal_users');
        $this->addSql('ALTER TABLE `users` DROP type');
    }
}
