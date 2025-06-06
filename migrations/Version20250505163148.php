<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250505163148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_user_like (post_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_778C728D4B89032C (post_id), INDEX IDX_778C728DA76ED395 (user_id), PRIMARY KEY(post_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_user_like ADD CONSTRAINT FK_778C728D4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_user_like ADD CONSTRAINT FK_778C728DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_user DROP FOREIGN KEY FK_44C6B1424B89032C');
        $this->addSql('ALTER TABLE post_user DROP FOREIGN KEY FK_44C6B142A76ED395');
        $this->addSql('DROP TABLE post_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_user (post_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_44C6B1424B89032C (post_id), INDEX IDX_44C6B142A76ED395 (user_id), PRIMARY KEY(post_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE post_user ADD CONSTRAINT FK_44C6B1424B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_user ADD CONSTRAINT FK_44C6B142A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_user_like DROP FOREIGN KEY FK_778C728D4B89032C');
        $this->addSql('ALTER TABLE post_user_like DROP FOREIGN KEY FK_778C728DA76ED395');
        $this->addSql('DROP TABLE post_user_like');
    }
}
