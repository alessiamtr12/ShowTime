<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250706152845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD booked_festival_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE72B58BAF FOREIGN KEY (booked_festival_id) REFERENCES festival (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE72B58BAF ON booking (booked_festival_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE72B58BAF');
        $this->addSql('DROP INDEX IDX_E00CEDDE72B58BAF ON booking');
        $this->addSql('ALTER TABLE booking DROP booked_festival_id');
    }
}
