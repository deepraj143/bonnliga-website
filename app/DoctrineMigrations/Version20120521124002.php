<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120521124002 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE WanderpokalBester DROP FOREIGN KEY FK_1ACCC17E3CC0D837");
        $this->addSql("ALTER TABLE WanderpokalBester ADD CONSTRAINT FK_1ACCC17E3CC0D837 FOREIGN KEY (rang_id) REFERENCES WanderpokalRang (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE WanderpokalRang DROP FOREIGN KEY FK_30ED9354B8C34D31");
        $this->addSql("ALTER TABLE WanderpokalRang ADD CONSTRAINT FK_30ED9354B8C34D31 FOREIGN KEY (monat_id) REFERENCES WanderpokalMonat (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE WanderpokalBester DROP FOREIGN KEY FK_1ACCC17E3CC0D837");
        $this->addSql("ALTER TABLE WanderpokalBester ADD CONSTRAINT FK_1ACCC17E3CC0D837 FOREIGN KEY (rang_id) REFERENCES WanderpokalRang (id)");
        $this->addSql("ALTER TABLE WanderpokalRang DROP FOREIGN KEY FK_30ED9354B8C34D31");
        $this->addSql("ALTER TABLE WanderpokalRang ADD CONSTRAINT FK_30ED9354B8C34D31 FOREIGN KEY (monat_id) REFERENCES WanderpokalMonat (id)");
    }
}