<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240917161423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount CHANGE discount_rate discount_rate DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE owner CHANGE rib rib VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE period_price CHANGE start_period start_period DATE DEFAULT NULL, CHANGE end_period end_period DATE DEFAULT NULL, CHANGE price_day price_day DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE property CHANGE planning planning JSON DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reservation CHANGE status status JSON NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE discount CHANGE discount_rate discount_rate DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE owner CHANGE rib rib VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE period_price CHANGE start_period start_period DATE DEFAULT \'NULL\', CHANGE end_period end_period DATE DEFAULT \'NULL\', CHANGE price_day price_day DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE property CHANGE planning planning LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reservation CHANGE status status LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
