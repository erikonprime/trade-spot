<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526135541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C48DE820D9');
        $this->addSql('DROP INDEX IDX_5475E8C48DE820D9 ON product_order');
        $this->addSql('ALTER TABLE product_order DROP seller_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_order ADD seller_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C48DE820D9 FOREIGN KEY (seller_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_5475E8C48DE820D9 ON product_order (seller_id)');
    }
}
