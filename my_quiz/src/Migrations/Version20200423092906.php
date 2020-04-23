<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423092906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question CHANGE id_categorie id_categorie SMALLINT DEFAULT NULL, CHANGE question question VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE id_question id_question SMALLINT DEFAULT NULL, CHANGE reponse reponse VARCHAR(255) DEFAULT NULL, CHANGE reponse_expected reponse_expected TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, DROP name, DROP admin, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question CHANGE id_categorie id_categorie SMALLINT DEFAULT NULL, CHANGE question question VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE reponse CHANGE id_question id_question SMALLINT DEFAULT NULL, CHANGE reponse reponse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_general_ci`, CHANGE reponse_expected reponse_expected TINYINT(1) DEFAULT \'NULL\'');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD admin TINYINT(1) DEFAULT \'NULL\', DROP roles, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
