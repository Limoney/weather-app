<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022145855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__measurement AS SELECT id, location_id, weather_condition_id, date, temperature_celsius FROM measurement');
        $this->addSql('DROP TABLE measurement');
        $this->addSql('CREATE TABLE measurement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, location_id INTEGER NOT NULL, weather_condition_id INTEGER NOT NULL, date DATE NOT NULL, temperature_celsius NUMERIC(3, 0) NOT NULL, CONSTRAINT FK_2CE0D81164D218E FOREIGN KEY (location_id) REFERENCES location (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2CE0D81186C2CF78 FOREIGN KEY (weather_condition_id) REFERENCES weather_condition (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO measurement (id, location_id, weather_condition_id, date, temperature_celsius) SELECT id, location_id, weather_condition_id, date, temperature_celsius FROM __temp__measurement');
        $this->addSql('DROP TABLE __temp__measurement');
        $this->addSql('CREATE INDEX IDX_2CE0D81186C2CF78 ON measurement (weather_condition_id)');
        $this->addSql('CREATE INDEX IDX_2CE0D81164D218E ON measurement (location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__measurement AS SELECT id, location_id, weather_condition_id, date, temperature_celsius FROM measurement');
        $this->addSql('DROP TABLE measurement');
        $this->addSql('CREATE TABLE measurement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, location_id INTEGER NOT NULL, weather_condition_id INTEGER DEFAULT NULL, date DATE NOT NULL, temperature_celsius NUMERIC(3, 0) NOT NULL, CONSTRAINT FK_2CE0D81164D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2CE0D81186C2CF78 FOREIGN KEY (weather_condition_id) REFERENCES weather_condition (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO measurement (id, location_id, weather_condition_id, date, temperature_celsius) SELECT id, location_id, weather_condition_id, date, temperature_celsius FROM __temp__measurement');
        $this->addSql('DROP TABLE __temp__measurement');
        $this->addSql('CREATE INDEX IDX_2CE0D81164D218E ON measurement (location_id)');
        $this->addSql('CREATE INDEX IDX_2CE0D81186C2CF78 ON measurement (weather_condition_id)');
    }
}
