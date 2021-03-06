<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120521115216 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("CREATE TABLE WanderpokalBester (id INT AUTO_INCREMENT NOT NULL, rang_id INT DEFAULT NULL, spieler_id INT DEFAULT NULL, punkte INT NOT NULL, INDEX IDX_1ACCC17E3CC0D837 (rang_id), INDEX IDX_1ACCC17E6EAF0EC3 (spieler_id), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE WanderpokalMonat (id INT AUTO_INCREMENT NOT NULL, monat DATE NOT NULL, PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("CREATE TABLE WanderpokalRang (id INT AUTO_INCREMENT NOT NULL, monat_id INT DEFAULT NULL, stammlokal_id INT DEFAULT NULL, punkte INT NOT NULL, INDEX IDX_30ED9354B8C34D31 (monat_id), INDEX IDX_30ED9354E342308D (stammlokal_id), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE WanderpokalBester ADD CONSTRAINT FK_1ACCC17E3CC0D837 FOREIGN KEY (rang_id) REFERENCES WanderpokalRang (id)");
        $this->addSql("ALTER TABLE WanderpokalBester ADD CONSTRAINT FK_1ACCC17E6EAF0EC3 FOREIGN KEY (spieler_id) REFERENCES Spieler (id)");
        $this->addSql("ALTER TABLE WanderpokalRang ADD CONSTRAINT FK_30ED9354B8C34D31 FOREIGN KEY (monat_id) REFERENCES WanderpokalMonat (id)");
        $this->addSql("ALTER TABLE WanderpokalRang ADD CONSTRAINT FK_30ED9354E342308D FOREIGN KEY (stammlokal_id) REFERENCES Location (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE WanderpokalRang DROP FOREIGN KEY FK_30ED9354B8C34D31");
        $this->addSql("ALTER TABLE WanderpokalBester DROP FOREIGN KEY FK_1ACCC17E3CC0D837");
        $this->addSql("DROP TABLE WanderpokalBester");
        $this->addSql("DROP TABLE WanderpokalMonat");
        $this->addSql("DROP TABLE WanderpokalRang");
    }
}
