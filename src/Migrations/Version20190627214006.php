<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190627214006 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f5299398a76ed395');
        $this->addSql('DROP INDEX idx_f5299398a76ed395');
        $this->addSql('ALTER TABLE "order" RENAME COLUMN user_id TO user_owner_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993989EB185F9 FOREIGN KEY (user_owner_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F52993989EB185F9 ON "order" (user_owner_id)');
        $this->addSql('ALTER TABLE users ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE users ALTER login TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9AA08CB10 ON users (login)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_1483A5E9AA08CB10');
        $this->addSql('ALTER TABLE users DROP roles');
        $this->addSql('ALTER TABLE users ALTER login TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993989EB185F9');
        $this->addSql('DROP INDEX IDX_F52993989EB185F9');
        $this->addSql('ALTER TABLE "order" RENAME COLUMN user_owner_id TO user_id');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f5299398a76ed395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f5299398a76ed395 ON "order" (user_id)');
    }
}
