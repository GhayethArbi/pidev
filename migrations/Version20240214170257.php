<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214170257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_physique CHANGE calories_brules calories_brules INT DEFAULT NULL, CHANGE duree_activite duree_activite INT DEFAULT NULL, CHANGE nb_serie nb_serie INT DEFAULT NULL, CHANGE nb_rep_serie nb_rep_serie INT DEFAULT NULL, CHANGE poids_par_serie poids_par_serie INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite_physique CHANGE calories_brules calories_brules INT NOT NULL, CHANGE duree_activite duree_activite INT NOT NULL, CHANGE nb_serie nb_serie INT NOT NULL, CHANGE nb_rep_serie nb_rep_serie INT NOT NULL, CHANGE poids_par_serie poids_par_serie INT NOT NULL');
    }
}
