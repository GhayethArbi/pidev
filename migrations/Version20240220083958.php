<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220083958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_backs ADD usersid_id INT NOT NULL');
        $this->addSql('ALTER TABLE feed_backs ADD CONSTRAINT FK_5651F779EDE8A042 FOREIGN KEY (usersid_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5651F779EDE8A042 ON feed_backs (usersid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feed_backs DROP FOREIGN KEY FK_5651F779EDE8A042');
        $this->addSql('DROP INDEX IDX_5651F779EDE8A042 ON feed_backs');
        $this->addSql('ALTER TABLE feed_backs DROP usersid_id');
    }
}
