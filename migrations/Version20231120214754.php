<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120214754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, answer_rule_id INT DEFAULT NULL, question_id INT NOT NULL, text LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_DADD4A253C0ECC20 (answer_rule_id), INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer_rule (id INT AUTO_INCREMENT NOT NULL, next_question_id INT DEFAULT NULL, is_all_excluded TINYINT(1) NOT NULL, INDEX IDX_18F34F0C1CF5F25E (next_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer_rule_recommended_product (answer_rule_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_DC4AE8C43C0ECC20 (answer_rule_id), INDEX IDX_DC4AE8C44584665A (product_id), PRIMARY KEY(answer_rule_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer_rule_excluded_product (answer_rule_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_3A061CD23C0ECC20 (answer_rule_id), INDEX IDX_3A061CD24584665A (product_id), PRIMARY KEY(answer_rule_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT NOT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_B6F7494ECE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire_submission (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT NOT NULL, internal_id VARCHAR(255) NOT NULL, customer_name VARCHAR(255) NOT NULL, submitted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', recommended_products JSON DEFAULT NULL, INDEX IDX_2CF49A6ACE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A253C0ECC20 FOREIGN KEY (answer_rule_id) REFERENCES answer_rule (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answer_rule ADD CONSTRAINT FK_18F34F0C1CF5F25E FOREIGN KEY (next_question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answer_rule_recommended_product ADD CONSTRAINT FK_DC4AE8C43C0ECC20 FOREIGN KEY (answer_rule_id) REFERENCES answer_rule (id)');
        $this->addSql('ALTER TABLE answer_rule_recommended_product ADD CONSTRAINT FK_DC4AE8C44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE answer_rule_excluded_product ADD CONSTRAINT FK_3A061CD23C0ECC20 FOREIGN KEY (answer_rule_id) REFERENCES answer_rule (id)');
        $this->addSql('ALTER TABLE answer_rule_excluded_product ADD CONSTRAINT FK_3A061CD24584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE questionnaire_submission ADD CONSTRAINT FK_2CF49A6ACE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A253C0ECC20');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE answer_rule DROP FOREIGN KEY FK_18F34F0C1CF5F25E');
        $this->addSql('ALTER TABLE answer_rule_recommended_product DROP FOREIGN KEY FK_DC4AE8C43C0ECC20');
        $this->addSql('ALTER TABLE answer_rule_recommended_product DROP FOREIGN KEY FK_DC4AE8C44584665A');
        $this->addSql('ALTER TABLE answer_rule_excluded_product DROP FOREIGN KEY FK_3A061CD23C0ECC20');
        $this->addSql('ALTER TABLE answer_rule_excluded_product DROP FOREIGN KEY FK_3A061CD24584665A');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECE07E8FF');
        $this->addSql('ALTER TABLE questionnaire_submission DROP FOREIGN KEY FK_2CF49A6ACE07E8FF');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE answer_rule');
        $this->addSql('DROP TABLE answer_rule_recommended_product');
        $this->addSql('DROP TABLE answer_rule_excluded_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questionnaire_submission');
    }
}
