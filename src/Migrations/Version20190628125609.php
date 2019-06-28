<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190628125609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT fk_2530ade68d9f6d38');
        $this->addSql('CREATE TABLE etton_order (id UUID NOT NULL, user_owner_id UUID NOT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47867A59EB185F9 ON etton_order (user_owner_id)');
        $this->addSql('ALTER TABLE etton_order ADD CONSTRAINT FK_47867A59EB185F9 FOREIGN KEY (user_owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('drop index idx_2530ade68d9f6d38;');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES etton_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT FK_2530ADE68D9F6D38');
        $this->addSql('CREATE TABLE "order" (id UUID NOT NULL, user_owner_id UUID NOT NULL, created_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_f52993989eb185f9 ON "order" (user_owner_id)');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f52993989eb185f9 FOREIGN KEY (user_owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE etton_order');
        $this->addSql('ALTER TABLE order_product DROP CONSTRAINT fk_2530ade68d9f6d38');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT fk_2530ade68d9f6d38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
