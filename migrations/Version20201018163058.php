<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201018163058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE solar_system_user (solar_system_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3CECD44EE5C8C6D3 (solar_system_id), INDEX IDX_3CECD44EA76ED395 (user_id), PRIMARY KEY(solar_system_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solar_system_user ADD CONSTRAINT FK_3CECD44EE5C8C6D3 FOREIGN KEY (solar_system_id) REFERENCES solar_system (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solar_system_user ADD CONSTRAINT FK_3CECD44EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solar_system ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE solar_system_user');
        $this->addSql('ALTER TABLE solar_system DROP created_at');
    }
}
