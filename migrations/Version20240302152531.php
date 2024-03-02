<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302152531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, titre_e VARCHAR(255) NOT NULL, date_debut_e DATETIME NOT NULL, status_e VARCHAR(255) NOT NULL, date_fin_e DATETIME NOT NULL, localisation_e VARCHAR(255) NOT NULL, description_e LONGTEXT NOT NULL, nbr_max_p INT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feed_back (id INT AUTO_INCREMENT NOT NULL, commentaire LONGTEXT NOT NULL, date_avis DATETIME NOT NULL, evaluation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, name_p VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, userx_id INT DEFAULT NULL, nomx_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_54469DF4B0B2333C (userx_id), INDEX IDX_54469DF4E96E72E4 (nomx_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4B0B2333C FOREIGN KEY (userx_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4E96E72E4 FOREIGN KEY (nomx_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4B0B2333C');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4E96E72E4');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE feed_back');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE tickets');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
