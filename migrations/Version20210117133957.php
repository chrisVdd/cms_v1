<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210117133957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE widget (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE widget_page (widget_id INT NOT NULL, page_id INT NOT NULL, INDEX IDX_8CFDBD9FFBE885E2 (widget_id), INDEX IDX_8CFDBD9FC4663E4 (page_id), PRIMARY KEY(widget_id, page_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE widget_page ADD CONSTRAINT FK_8CFDBD9FFBE885E2 FOREIGN KEY (widget_id) REFERENCES widget (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE widget_page ADD CONSTRAINT FK_8CFDBD9FC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE widget_page DROP FOREIGN KEY FK_8CFDBD9FFBE885E2');
        $this->addSql('DROP TABLE widget');
        $this->addSql('DROP TABLE widget_page');
    }
}
