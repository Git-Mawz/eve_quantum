<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908091905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suggest ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE suggest ADD CONSTRAINT FK_8B867B86A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8B867B86A76ED395 ON suggest (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suggest DROP FOREIGN KEY FK_8B867B86A76ED395');
        $this->addSql('DROP INDEX IDX_8B867B86A76ED395 ON suggest');
        $this->addSql('ALTER TABLE suggest DROP user_id');
    }
}
