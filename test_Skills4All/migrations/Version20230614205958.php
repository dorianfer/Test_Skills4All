<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614205958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_category DROP FOREIGN KEY FK_897A2CC5A0EF1B80');
        $this->addSql('DROP INDEX IDX_897A2CC5A0EF1B80 ON car_category');
        $this->addSql('ALTER TABLE car_category CHANGE car_id_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_category ADD CONSTRAINT FK_897A2CC5C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_897A2CC5C3C6F69F ON car_category (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_category DROP FOREIGN KEY FK_897A2CC5C3C6F69F');
        $this->addSql('DROP INDEX IDX_897A2CC5C3C6F69F ON car_category');
        $this->addSql('ALTER TABLE car_category CHANGE car_id car_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car_category ADD CONSTRAINT FK_897A2CC5A0EF1B80 FOREIGN KEY (car_id_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_897A2CC5A0EF1B80 ON car_category (car_id_id)');
    }
}
