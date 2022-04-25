<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406224025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE barber (id INT AUTO_INCREMENT NOT NULL, id_salon_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, INDEX IDX_7C48A9A41C4A5171 (id_salon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salon (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slots (id INT AUTO_INCREMENT NOT NULL, id_salon_id INT DEFAULT NULL, id_barber_id INT DEFAULT NULL, id_user_id INT DEFAULT NULL, INDEX IDX_C87435D01C4A5171 (id_salon_id), INDEX IDX_C87435D03FC742D5 (id_barber_id), INDEX IDX_C87435D079F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE barber ADD CONSTRAINT FK_7C48A9A41C4A5171 FOREIGN KEY (id_salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE slots ADD CONSTRAINT FK_C87435D01C4A5171 FOREIGN KEY (id_salon_id) REFERENCES salon (id)');
        $this->addSql('ALTER TABLE slots ADD CONSTRAINT FK_C87435D03FC742D5 FOREIGN KEY (id_barber_id) REFERENCES barber (id)');
        $this->addSql('ALTER TABLE slots ADD CONSTRAINT FK_C87435D079F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slots DROP FOREIGN KEY FK_C87435D03FC742D5');
        $this->addSql('ALTER TABLE barber DROP FOREIGN KEY FK_7C48A9A41C4A5171');
        $this->addSql('ALTER TABLE slots DROP FOREIGN KEY FK_C87435D01C4A5171');
        $this->addSql('ALTER TABLE slots DROP FOREIGN KEY FK_C87435D079F37AE5');
        $this->addSql('DROP TABLE barber');
        $this->addSql('DROP TABLE salon');
        $this->addSql('DROP TABLE slots');
        $this->addSql('DROP TABLE user');
    }
}
