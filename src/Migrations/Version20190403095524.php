<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190403095524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE instrument ADD category_id INT DEFAULT NULL, DROP category');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DD12469DE2 ON instrument (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DD12469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_3CBF69DD12469DE2 ON instrument');
        $this->addSql('ALTER TABLE instrument ADD category VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, DROP category_id');
    }
}
