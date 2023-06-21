<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230621193542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE branch (id INT AUTO_INCREMENT NOT NULL, repo_id INT NOT NULL, ref VARCHAR(255) NOT NULL, before_commit VARCHAR(255) NOT NULL, after_commit VARCHAR(255) NOT NULL, pusher VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_BB861B1FBD359B2D (repo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE build (id INT AUTO_INCREMENT NOT NULL, branch_id INT DEFAULT NULL, pull_request_id INT DEFAULT NULL, INDEX IDX_BDA0F2DBDCD6CC49 (branch_id), INDEX IDX_BDA0F2DB4CE0BF7E (pull_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pull_request (id INT AUTO_INCREMENT NOT NULL, repo_id INT NOT NULL, number INT NOT NULL, title VARCHAR(255) NOT NULL, pusher VARCHAR(255) NOT NULL, base_ref VARCHAR(255) NOT NULL, change_ref VARCHAR(255) NOT NULL, base_commit VARCHAR(255) NOT NULL, head_commit VARCHAR(255) NOT NULL, INDEX IDX_8B9B9EEFBD359B2D (repo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repo (id INT AUTO_INCREMENT NOT NULL, repository_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE branch ADD CONSTRAINT FK_BB861B1FBD359B2D FOREIGN KEY (repo_id) REFERENCES repo (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DBDCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DB4CE0BF7E FOREIGN KEY (pull_request_id) REFERENCES pull_request (id)');
        $this->addSql('ALTER TABLE pull_request ADD CONSTRAINT FK_8B9B9EEFBD359B2D FOREIGN KEY (repo_id) REFERENCES repo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE branch DROP FOREIGN KEY FK_BB861B1FBD359B2D');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DBDCD6CC49');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DB4CE0BF7E');
        $this->addSql('ALTER TABLE pull_request DROP FOREIGN KEY FK_8B9B9EEFBD359B2D');
        $this->addSql('DROP TABLE branch');
        $this->addSql('DROP TABLE build');
        $this->addSql('DROP TABLE pull_request');
        $this->addSql('DROP TABLE repo');
        $this->addSql('DROP TABLE step');
    }
}
