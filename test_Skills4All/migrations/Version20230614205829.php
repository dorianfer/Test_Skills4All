<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614205829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DF50D004F');
        $this->addSql('ALTER TABLE car_category DROP FOREIGN KEY FK_897A2CC5F50D004F');
        $this->addSql('DROP TABLE belonging');
        $this->addSql('DROP INDEX UNIQ_773DE69DF50D004F ON car');
        $this->addSql('ALTER TABLE car DROP belonging_id_id');
        $this->addSql('DROP INDEX IDX_897A2CC5F50D004F ON car_category');
        $this->addSql('ALTER TABLE car_category CHANGE belonging_id_id car_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_category ADD CONSTRAINT FK_897A2CC5A0EF1B80 FOREIGN KEY (car_id_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_897A2CC5A0EF1B80 ON car_category (car_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE belonging (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE car ADD belonging_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DF50D004F FOREIGN KEY (belonging_id_id) REFERENCES belonging (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_773DE69DF50D004F ON car (belonging_id_id)');
        $this->addSql('ALTER TABLE car_category DROP FOREIGN KEY FK_897A2CC5A0EF1B80');
        $this->addSql('DROP INDEX IDX_897A2CC5A0EF1B80 ON car_category');
        $this->addSql('ALTER TABLE car_category CHANGE car_id_id belonging_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_category ADD CONSTRAINT FK_897A2CC5F50D004F FOREIGN KEY (belonging_id_id) REFERENCES belonging (id)');
        $this->addSql('CREATE INDEX IDX_897A2CC5F50D004F ON car_category (belonging_id_id)');
    }
}
