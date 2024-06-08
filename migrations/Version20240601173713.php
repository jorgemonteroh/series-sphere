<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601173713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capitulo DROP FOREIGN KEY FK_2BA5E28F4DDD8DDA');
        $this->addSql('DROP TABLE capitulo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capitulo (id INT AUTO_INCREMENT NOT NULL, id_temporada_id INT NOT NULL, numero_cap INT NOT NULL, fecha_creacion DATETIME NOT NULL, INDEX IDX_2BA5E28F4DDD8DDA (id_temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE capitulo ADD CONSTRAINT FK_2BA5E28F4DDD8DDA FOREIGN KEY (id_temporada_id) REFERENCES temporada (id)');
    }
}
