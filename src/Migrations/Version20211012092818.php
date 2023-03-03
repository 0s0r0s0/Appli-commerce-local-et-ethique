<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211012092818 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE association (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, siret VARCHAR(20) NOT NULL, asso_name VARCHAR(100) NOT NULL, asso_adress VARCHAR(255) NOT NULL, asso_postal_code VARCHAR(10) NOT NULL, asso_city VARCHAR(50) NOT NULL, image VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(25) NOT NULL, tva_intracom VARCHAR(25) NOT NULL, email VARCHAR(100) NOT NULL, INDEX IDX_FD8521CCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE basket (id INT AUTO_INCREMENT NOT NULL, price INT NOT NULL, delivery_tax DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, customer_id INT NOT NULL, sub_id_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, reference VARCHAR(100) NOT NULL, date DATE NOT NULL, price_ht DOUBLE PRECISION NOT NULL, tva DOUBLE PRECISION NOT NULL, delivery_tax DOUBLE PRECISION NOT NULL, price_ttc DOUBLE PRECISION NOT NULL, INDEX IDX_FE866410A76ED395 (user_id), INDEX IDX_FE8664109395C3F3 (customer_id), UNIQUE INDEX UNIQ_FE8664109300FAEE (sub_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE good (id INT AUTO_INCREMENT NOT NULL, producer_id INT NOT NULL, goods_type_id INT DEFAULT NULL, rate_id INT NOT NULL, labelled_type_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, buying_minimum VARCHAR(20) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, stock INT NOT NULL, label VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6C844E9289B658FE (producer_id), INDEX IDX_6C844E92201AE29E (goods_type_id), INDEX IDX_6C844E92BC999F9F (rate_id), INDEX IDX_6C844E92628321B5 (labelled_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goods_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE labelled_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producer (id INT AUTO_INCREMENT NOT NULL, production_type_id INT NOT NULL, user_id INT NOT NULL, siret VARCHAR(20) NOT NULL, firm_name VARCHAR(255) NOT NULL, firm_adress VARCHAR(255) NOT NULL, firm_postal_code VARCHAR(10) NOT NULL, firm_city VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(25) NOT NULL, updated_at DATETIME DEFAULT NULL, tva_intracom VARCHAR(20) NOT NULL, INDEX IDX_976449DCD059014E (production_type_id), UNIQUE INDEX UNIQ_976449DCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(25) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, unit_type_id INT NOT NULL, price VARCHAR(20) NOT NULL, INDEX IDX_DFEC3F3991058251 (unit_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, facture_id INT DEFAULT NULL, quantity INT NOT NULL, frequency INT DEFAULT NULL, price INT NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, paid TINYINT(1) NOT NULL, bonus DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, price_with_tax DOUBLE PRECISION NOT NULL, INDEX IDX_A3C664D3A76ED395 (user_id), INDEX IDX_A3C664D37F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trade_area (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trimester (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, profile_id INT NOT NULL, trade_area_id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), UNIQUE INDEX UNIQ_8D93D649CCFA12B8 (profile_id), INDEX IDX_8D93D6494E8F186A (trade_area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE association ADD CONSTRAINT FK_FD8521CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664109395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664109300FAEE FOREIGN KEY (sub_id_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE good ADD CONSTRAINT FK_6C844E9289B658FE FOREIGN KEY (producer_id) REFERENCES producer (id)');
        $this->addSql('ALTER TABLE good ADD CONSTRAINT FK_6C844E92201AE29E FOREIGN KEY (goods_type_id) REFERENCES goods_type (id)');
        $this->addSql('ALTER TABLE good ADD CONSTRAINT FK_6C844E92BC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
        $this->addSql('ALTER TABLE good ADD CONSTRAINT FK_6C844E92628321B5 FOREIGN KEY (labelled_type_id) REFERENCES labelled_type (id)');
        $this->addSql('ALTER TABLE producer ADD CONSTRAINT FK_976449DCD059014E FOREIGN KEY (production_type_id) REFERENCES production_type (id)');
        $this->addSql('ALTER TABLE producer ADD CONSTRAINT FK_976449DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F3991058251 FOREIGN KEY (unit_type_id) REFERENCES unit_type (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D37F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494E8F186A FOREIGN KEY (trade_area_id) REFERENCES trade_area (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D37F2DEE08');
        $this->addSql('ALTER TABLE good DROP FOREIGN KEY FK_6C844E92201AE29E');
        $this->addSql('ALTER TABLE good DROP FOREIGN KEY FK_6C844E92628321B5');
        $this->addSql('ALTER TABLE good DROP FOREIGN KEY FK_6C844E9289B658FE');
        $this->addSql('ALTER TABLE producer DROP FOREIGN KEY FK_976449DCD059014E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE good DROP FOREIGN KEY FK_6C844E92BC999F9F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664109300FAEE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494E8F186A');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F3991058251');
        $this->addSql('ALTER TABLE association DROP FOREIGN KEY FK_FD8521CCA76ED395');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410A76ED395');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664109395C3F3');
        $this->addSql('ALTER TABLE producer DROP FOREIGN KEY FK_976449DCA76ED395');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE basket');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE good');
        $this->addSql('DROP TABLE goods_type');
        $this->addSql('DROP TABLE labelled_type');
        $this->addSql('DROP TABLE producer');
        $this->addSql('DROP TABLE production_type');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE trade_area');
        $this->addSql('DROP TABLE trimester');
        $this->addSql('DROP TABLE unit_type');
        $this->addSql('DROP TABLE user');
    }
}
