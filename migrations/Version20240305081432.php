<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305081432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_physique CHANGE image_activite image_activite VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE objectif CHANGE date_objectif date_objectif DATETIME NOT NULL');
        $this->addSql('ALTER TABLE objectif_activite_physique ADD CONSTRAINT FK_74FA080D157D1AD4 FOREIGN KEY (objectif_id) REFERENCES objectif (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objectif_activite_physique ADD CONSTRAINT FK_74FA080D73E392B5 FOREIGN KEY (activite_physique_id) REFERENCES activite_physique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD quantite INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE registration_date registration_date DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_physique CHANGE image_activite image_activite VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE objectif CHANGE date_objectif date_objectif DATE NOT NULL');
        $this->addSql('ALTER TABLE product DROP quantite');
        $this->addSql('ALTER TABLE objectif_activite_physique DROP FOREIGN KEY FK_74FA080D157D1AD4');
        $this->addSql('ALTER TABLE objectif_activite_physique DROP FOREIGN KEY FK_74FA080D73E392B5');
        $this->addSql('ALTER TABLE user CHANGE registration_date registration_date DATE DEFAULT NULL');
    }
}
