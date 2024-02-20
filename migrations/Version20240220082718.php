<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220082718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produitfitness ADD ref_p_id INT NOT NULL');
        $this->addSql('ALTER TABLE produitfitness ADD CONSTRAINT FK_3911CDC4082225 FOREIGN KEY (ref_p_id) REFERENCES feed_backs (id)');
        $this->addSql('CREATE INDEX IDX_3911CDC4082225 ON produitfitness (ref_p_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produitfitness DROP FOREIGN KEY FK_3911CDC4082225');
        $this->addSql('DROP INDEX IDX_3911CDC4082225 ON produitfitness');
        $this->addSql('ALTER TABLE produitfitness DROP ref_p_id');
    }
}
