<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226000941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite_physique (id INT AUTO_INCREMENT NOT NULL, nom_activite VARCHAR(255) NOT NULL, type_activite VARCHAR(255) NOT NULL, duree_activite INT DEFAULT NULL, calories_brules INT DEFAULT NULL, nb_series INT DEFAULT NULL, nb_rep_series INT DEFAULT NULL, poids_par_serie INT DEFAULT NULL, image_activite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif (id INT AUTO_INCREMENT NOT NULL, nom_objectif VARCHAR(255) NOT NULL, date_objectif DATE NOT NULL, total_calories INT DEFAULT NULL, total_duree INT DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif_activite_physique (objectif_id INT NOT NULL, activite_physique_id INT NOT NULL, INDEX IDX_74FA080D157D1AD4 (objectif_id), INDEX IDX_74FA080D73E392B5 (activite_physique_id), PRIMARY KEY(objectif_id, activite_physique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE objectif_activite_physique ADD CONSTRAINT FK_74FA080D157D1AD4 FOREIGN KEY (objectif_id) REFERENCES objectif (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE objectif_activite_physique ADD CONSTRAINT FK_74FA080D73E392B5 FOREIGN KEY (activite_physique_id) REFERENCES activite_physique (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE objectif_activite_physique DROP FOREIGN KEY FK_74FA080D157D1AD4');
        $this->addSql('ALTER TABLE objectif_activite_physique DROP FOREIGN KEY FK_74FA080D73E392B5');
        $this->addSql('DROP TABLE activite_physique');
        $this->addSql('DROP TABLE objectif');
        $this->addSql('DROP TABLE objectif_activite_physique');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
