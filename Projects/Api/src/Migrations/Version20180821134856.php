<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180821134856 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(1000) DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_band (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, band_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_325EEE22A76ED395 (user_id), INDEX IDX_325EEE2249ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (id INT AUTO_INCREMENT NOT NULL, user_a_id INT NOT NULL, user_b_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F7129A80415F1F91 (user_a_id), INDEX IDX_F7129A8053EAB07F (user_b_id), UNIQUE INDEX relation (user_a_id, user_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE22A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_band ADD CONSTRAINT FK_325EEE2249ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80415F1F91 FOREIGN KEY (user_a_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A8053EAB07F FOREIGN KEY (user_b_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_band DROP FOREIGN KEY FK_325EEE2249ABEB17');
        $this->addSql('ALTER TABLE user_band DROP FOREIGN KEY FK_325EEE22A76ED395');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80415F1F91');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A8053EAB07F');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_band');
        $this->addSql('DROP TABLE user_user');
    }
}
