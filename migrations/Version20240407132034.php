<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407132034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contador_capitulos (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, serie_id INT NOT NULL, temporada_id INT NOT NULL, capitulo_actual INT NOT NULL, INDEX IDX_A1F681A8DB38439E (usuario_id), INDEX IDX_A1F681A8D94388BD (serie_id), INDEX IDX_A1F681A86E1CF8A8 (temporada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contador_capitulos ADD CONSTRAINT FK_A1F681A8DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE contador_capitulos ADD CONSTRAINT FK_A1F681A8D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE contador_capitulos ADD CONSTRAINT FK_A1F681A86E1CF8A8 FOREIGN KEY (temporada_id) REFERENCES temporada (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contador_capitulos DROP FOREIGN KEY FK_A1F681A8DB38439E');
        $this->addSql('ALTER TABLE contador_capitulos DROP FOREIGN KEY FK_A1F681A8D94388BD');
        $this->addSql('ALTER TABLE contador_capitulos DROP FOREIGN KEY FK_A1F681A86E1CF8A8');
        $this->addSql('DROP TABLE contador_capitulos');
    }
}
