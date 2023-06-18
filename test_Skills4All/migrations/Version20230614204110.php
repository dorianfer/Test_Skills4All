<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614204110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE belonging (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, belonging_id_id INT DEFAULT NULL, nb_seats INT NOT NULL, nb_doors INT NOT NULL, name VARCHAR(255) NOT NULL, cost NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_773DE69DF50D004F (belonging_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_category (id INT AUTO_INCREMENT NOT NULL, belonging_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_897A2CC5F50D004F (belonging_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF50D004F FOREIGN KEY (belonging_id_id) REFERENCES belonging (id)');
        $this->addSql('ALTER TABLE car_category ADD CONSTRAINT FK_897A2CC5F50D004F FOREIGN KEY (belonging_id_id) REFERENCES belonging (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF50D004F');
        $this->addSql('ALTER TABLE car_category DROP FOREIGN KEY FK_897A2CC5F50D004F');
        $this->addSql('DROP TABLE belonging');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_category');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
