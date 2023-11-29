<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129114614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eaten_meals (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, meal_id INT DEFAULT NULL, INDEX IDX_433F44B3A76ED395 (user_id), INDEX IDX_433F44B3639666D6 (meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eaten_meals ADD CONSTRAINT FK_433F44B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eaten_meals ADD CONSTRAINT FK_433F44B3639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eaten_meals DROP FOREIGN KEY FK_433F44B3A76ED395');
        $this->addSql('ALTER TABLE eaten_meals DROP FOREIGN KEY FK_433F44B3639666D6');
        $this->addSql('DROP TABLE eaten_meals');
    }
}
