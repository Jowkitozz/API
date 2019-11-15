<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191115090816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_1483A5E9F85E0677 ON users');
        $this->addSql('ALTER TABLE users ADD name VARCHAR(500) NOT NULL, ADD first_name VARCHAR(500) NOT NULL, DROP is_active, CHANGE username number_account VARCHAR(25) NOT NULL, CHANGE password pin_code VARCHAR(500) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9AA46231 ON users (number_account)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_1483A5E9AA46231 ON users');
        $this->addSql('ALTER TABLE users ADD password VARCHAR(500) NOT NULL COLLATE utf8mb4_unicode_ci, ADD is_active TINYINT(1) NOT NULL, DROP pin_code, DROP name, DROP first_name, CHANGE number_account username VARCHAR(25) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }
}
