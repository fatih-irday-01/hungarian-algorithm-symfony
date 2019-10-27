<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191027204159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE developers (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ability INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developers_jobs (id INT AUTO_INCREMENT NOT NULL, developer_id INT NOT NULL, job_id INT NOT NULL, run_timer INT NOT NULL, sequence INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, level INT DEFAULT NULL, duration INT DEFAULT NULL, UNIQUE INDEX UNIQ_A8936DC55E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $developers = array(
            array('name' => 'developer 1', 'ability' => 1),
            array('name' => 'developer 2', 'ability' => 2),
            array('name' => 'developer 3', 'ability' => 3),
            array('name' => 'developer 4', 'ability' => 4),
            array('name' => 'developer 5', 'ability' => 5),
        );

        foreach ($developers as $developer) {
            $this->addSql('INSERT INTO developers (name,ability) VALUES (:name,:ability);', $developer);
        }

    }

    public function postUp(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO developers (id,name,ability) VALUES (1,\'developer 1\',1)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE developers');
        $this->addSql('DROP TABLE developers_jobs');
        $this->addSql('DROP TABLE jobs');
    }
}
