<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525205844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, doctor_id INT DEFAULT NULL, consultation_details LONGTEXT NOT NULL, consultation_created_at DATETIME NOT NULL, consultation_updated_at DATETIME NOT NULL, consultation_date DATETIME NOT NULL, INDEX IDX_964685A66B899279 (patient_id), INDEX IDX_964685A687F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diagnostic (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, diagnostic_description LONGTEXT NOT NULL, diagnostic_created_at DATETIME NOT NULL, diagnostic_updated_at DATETIME NOT NULL, INDEX IDX_FA7C888962FF6CDF (consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, doctor_created_at DATETIME NOT NULL, doctor_updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_history (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, medical_history_name VARCHAR(255) NOT NULL, medical_history_details LONGTEXT NOT NULL, medical_history_created_at DATETIME NOT NULL, medical_history_updated_at DATETIME NOT NULL, medical_history_date DATETIME NOT NULL, INDEX IDX_61B890856B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_prescription (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, doctor_id INT DEFAULT NULL, medical_prescription_description LONGTEXT NOT NULL, medical_prescription_created_at DATETIME NOT NULL, medical_prescription_updated_at DATETIME NOT NULL, INDEX IDX_3A4293B662FF6CDF (consultation_id), INDEX IDX_3A4293B687F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medication (id INT AUTO_INCREMENT NOT NULL, medical_prescription_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, medication_name VARCHAR(255) NOT NULL, medication_dosage VARCHAR(255) NOT NULL, medication_form VARCHAR(255) NOT NULL, medication_created_at DATETIME NOT NULL, medication_updated_at DATETIME NOT NULL, INDEX IDX_5AEE5B70652CBECD (medical_prescription_id), INDEX IDX_5AEE5B706B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, social_security_number VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, gender VARCHAR(255) NOT NULL, marital_status VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone_number INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, blood_type VARCHAR(255) NOT NULL, patient_created_at DATETIME NOT NULL, patient_updated_at DATETIME NOT NULL, INDEX IDX_1ADAD7EB87F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A687F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE diagnostic ADD CONSTRAINT FK_FA7C888962FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE medical_history ADD CONSTRAINT FK_61B890856B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE medical_prescription ADD CONSTRAINT FK_3A4293B662FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE medical_prescription ADD CONSTRAINT FK_3A4293B687F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE medication ADD CONSTRAINT FK_5AEE5B70652CBECD FOREIGN KEY (medical_prescription_id) REFERENCES medical_prescription (id)');
        $this->addSql('ALTER TABLE medication ADD CONSTRAINT FK_5AEE5B706B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB87F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnostic DROP FOREIGN KEY FK_FA7C888962FF6CDF');
        $this->addSql('ALTER TABLE medical_prescription DROP FOREIGN KEY FK_3A4293B662FF6CDF');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A687F4FB17');
        $this->addSql('ALTER TABLE medical_prescription DROP FOREIGN KEY FK_3A4293B687F4FB17');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB87F4FB17');
        $this->addSql('ALTER TABLE medication DROP FOREIGN KEY FK_5AEE5B70652CBECD');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE medical_history DROP FOREIGN KEY FK_61B890856B899279');
        $this->addSql('ALTER TABLE medication DROP FOREIGN KEY FK_5AEE5B706B899279');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE diagnostic');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE medical_history');
        $this->addSql('DROP TABLE medical_prescription');
        $this->addSql('DROP TABLE medication');
        $this->addSql('DROP TABLE patient');
    }
}
