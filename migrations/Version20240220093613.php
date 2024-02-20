<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220093613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_back ADD userid_id INT NOT NULL');
        $this->addSql('ALTER TABLE feed_back ADD CONSTRAINT FK_ED592A6058E0A285 FOREIGN KEY (userid_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_ED592A6058E0A285 ON feed_back (userid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_back DROP FOREIGN KEY FK_ED592A6058E0A285');
        $this->addSql('DROP INDEX IDX_ED592A6058E0A285 ON feed_back');
        $this->addSql('ALTER TABLE feed_back DROP userid_id');
    }
}
