<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221209154853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_offer_applicant (job_offer_id UUID NOT NULL, applicant_id UUID NOT NULL, PRIMARY KEY(job_offer_id, applicant_id))');
        $this->addSql('CREATE INDEX IDX_82F422B23481D195 ON job_offer_applicant (job_offer_id)');
        $this->addSql('CREATE INDEX IDX_82F422B297139001 ON job_offer_applicant (applicant_id)');
        $this->addSql('COMMENT ON COLUMN job_offer_applicant.job_offer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN job_offer_applicant.applicant_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE job_offer_applicant ADD CONSTRAINT FK_82F422B23481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE job_offer_applicant ADD CONSTRAINT FK_82F422B297139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE applicant ADD cv_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN applicant.cv_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE applicant ADD CONSTRAINT FK_CAAD1019CFE419E2 FOREIGN KEY (cv_id) REFERENCES applicant_cv (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CAAD1019CFE419E2 ON applicant (cv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE job_offer_applicant DROP CONSTRAINT FK_82F422B23481D195');
        $this->addSql('ALTER TABLE job_offer_applicant DROP CONSTRAINT FK_82F422B297139001');
        $this->addSql('DROP TABLE job_offer_applicant');
        $this->addSql('ALTER TABLE applicant DROP CONSTRAINT FK_CAAD1019CFE419E2');
        $this->addSql('DROP INDEX UNIQ_CAAD1019CFE419E2');
        $this->addSql('ALTER TABLE applicant DROP cv_id');
    }
}
