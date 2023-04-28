<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425180038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_articles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_articles_articles (liste_articles_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_ABDDC1837C42A20 (liste_articles_id), INDEX IDX_ABDDC1831EBAF6CC (articles_id), PRIMARY KEY(liste_articles_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste_articles_articles ADD CONSTRAINT FK_ABDDC1837C42A20 FOREIGN KEY (liste_articles_id) REFERENCES liste_articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_articles_articles ADD CONSTRAINT FK_ABDDC1831EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_articles_articles DROP FOREIGN KEY FK_ABDDC1837C42A20');
        $this->addSql('ALTER TABLE liste_articles_articles DROP FOREIGN KEY FK_ABDDC1831EBAF6CC');
        $this->addSql('DROP TABLE liste_articles');
        $this->addSql('DROP TABLE liste_articles_articles');
    }
}
