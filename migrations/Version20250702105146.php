<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250702105146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE festival (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, location VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE festival_band (festival_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_92214B7C8AEBAF57 (festival_id), INDEX IDX_92214B7C49ABEB17 (band_id), PRIMARY KEY(festival_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE festival_band ADD CONSTRAINT FK_92214B7C8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE festival_band ADD CONSTRAINT FK_92214B7C49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE festival_band DROP FOREIGN KEY FK_92214B7C8AEBAF57');
        $this->addSql('ALTER TABLE festival_band DROP FOREIGN KEY FK_92214B7C49ABEB17');
        $this->addSql('DROP TABLE festival');
        $this->addSql('DROP TABLE festival_band');
    }
}
