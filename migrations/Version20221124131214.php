<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124131214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ami (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, ami_id INT NOT NULL, INDEX IDX_5269B413FB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_5269B413CCE66A0B (ami_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ami ADD CONSTRAINT FK_5269B413FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ami ADD CONSTRAINT FK_5269B413CCE66A0B FOREIGN KEY (ami_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ami DROP FOREIGN KEY FK_5269B413FB88E14F');
        $this->addSql('ALTER TABLE ami DROP FOREIGN KEY FK_5269B413CCE66A0B');
        $this->addSql('DROP TABLE ami');
    }
}
