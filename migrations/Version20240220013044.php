<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220013044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plan_nutritionnel (id INT AUTO_INCREMENT NOT NULL, recettes_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, INDEX IDX_E8846D5C3E2ED6D6 (recettes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plan_nutritionnel ADD CONSTRAINT FK_E8846D5C3E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recette (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plan_nutritionnel DROP FOREIGN KEY FK_E8846D5C3E2ED6D6');
        $this->addSql('DROP TABLE plan_nutritionnel');
    }
}
