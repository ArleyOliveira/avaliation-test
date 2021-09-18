<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210918040254 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', salt VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1483A5E9C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_users (id INT NOT NULL, nome VARCHAR(200) NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE physical_users (id INT NOT NULL, cpf VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8635B09F3E3E11F0 (cpf), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE legal_users (id INT NOT NULL, cnpj VARCHAR(14) NOT NULL, UNIQUE INDEX UNIQ_41ABF828C8C6906B (cnpj), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person_users ADD CONSTRAINT FK_B8B5BA2DBF396750 FOREIGN KEY (id) REFERENCES `users` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE physical_users ADD CONSTRAINT FK_8635B09FBF396750 FOREIGN KEY (id) REFERENCES `users` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE legal_users ADD CONSTRAINT FK_41ABF828BF396750 FOREIGN KEY (id) REFERENCES `users` (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE person_users DROP FOREIGN KEY FK_B8B5BA2DBF396750');
        $this->addSql('ALTER TABLE physical_users DROP FOREIGN KEY FK_8635B09FBF396750');
        $this->addSql('ALTER TABLE legal_users DROP FOREIGN KEY FK_41ABF828BF396750');
        $this->addSql('DROP TABLE `users`');
        $this->addSql('DROP TABLE person_users');
        $this->addSql('DROP TABLE physical_users');
        $this->addSql('DROP TABLE legal_users');
    }
}
