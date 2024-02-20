<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220094039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_back ADD ref_id INT NOT NULL');
        $this->addSql('ALTER TABLE feed_back ADD CONSTRAINT FK_ED592A6021B741A9 FOREIGN KEY (ref_id) REFERENCES produitfitness (id)');
        $this->addSql('CREATE INDEX IDX_ED592A6021B741A9 ON feed_back (ref_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_back DROP FOREIGN KEY FK_ED592A6021B741A9');
        $this->addSql('DROP INDEX IDX_ED592A6021B741A9 ON feed_back');
        $this->addSql('ALTER TABLE feed_back DROP ref_id');
    }
}
