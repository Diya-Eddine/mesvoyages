<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260309155323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite ADD datecreation DATE DEFAULT NULL, ADD tempmin INT DEFAULT NULL, ADD tempmax INT DEFAULT NULL, DROP temp_min, DROP temp_max, DROP date, CHANGE ville ville VARCHAR(50) NOT NULL, CHANGE pays pays VARCHAR(50) NOT NULL, CHANGE note note INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visite_environnement ADD CONSTRAINT FK_6690F746C1C5DC59 FOREIGN KEY (visite_id) REFERENCES visite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite_environnement ADD CONSTRAINT FK_6690F746BAFB82A1 FOREIGN KEY (environnement_id) REFERENCES environnement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite ADD temp_min INT NOT NULL, ADD temp_max INT NOT NULL, ADD date DATE NOT NULL, DROP datecreation, DROP tempmin, DROP tempmax, CHANGE ville ville VARCHAR(255) NOT NULL, CHANGE pays pays VARCHAR(255) NOT NULL, CHANGE note note INT NOT NULL');
        $this->addSql('ALTER TABLE visite_environnement DROP FOREIGN KEY FK_6690F746C1C5DC59');
        $this->addSql('ALTER TABLE visite_environnement DROP FOREIGN KEY FK_6690F746BAFB82A1');
    }
}
