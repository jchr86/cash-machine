<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 26/08/19
 * Time: 11:38
 */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Client, Account & Movement tables.
 *
 * @author JCHR <car.chr@gmail.com>
 */
final class Version20190826163740 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema): void
    {
        $this->addSql($this->sqlClient());
        $this->addSql($this->sqlAccount());
        $this->addSql($this->sqlMovement());
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F79B6B5FBA');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A419EB6921');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE client');
    }

    /**
     * SQL client.
     *
     * @return string
     */
    private function sqlClient(): string
    {
        $sql = <<<SQL
CREATE TABLE client (
    id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(80) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    gender SMALLINT NOT NULL,
    street VARCHAR(50) NOT NULL,
    external_num VARCHAR(30) NOT NULL,
    internal_num VARCHAR(30) DEFAULT NULL,
    suburb VARCHAR(100) NOT NULL,
    town VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    postal_code VARCHAR(5) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    UNIQUE INDEX UNIQ_C7440455E7927C74 (email),
    PRIMARY KEY(id)
)
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ENGINE = InnoDB
SQL;

        return $sql;
    }

    /**
     * SQL account.
     *
     * @return string
     */
    private function sqlAccount(): string
    {
        $sql = <<<SQL
CREATE TABLE account (
    id INT AUTO_INCREMENT NOT NULL,
    client_id INT NOT NULL,
    number VARCHAR(10) DEFAULT NULL,
    clabe VARCHAR(18) DEFAULT NULL,
    card_number VARCHAR(16) NOT NULL,
    expiry_month SMALLINT NOT NULL,
    expiry_year SMALLINT NOT NULL,
    cvc SMALLINT NOT NULL,
    amount NUMERIC(10, 2) NOT NULL,
    balance NUMERIC(10, 2) DEFAULT NULL,
    type SMALLINT NOT NULL,
    pin VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    UNIQUE INDEX UNIQ_7D3656A496901F54 (number),
    UNIQUE INDEX UNIQ_7D3656A44A468FDE (clabe),
    UNIQUE INDEX UNIQ_7D3656A4E4AF4C20 (card_number),
    INDEX IDX_7D3656A419EB6921 (client_id),
    PRIMARY KEY(id),
    CONSTRAINT FK_7D3656A419EB6921
        FOREIGN KEY (client_id)
        REFERENCES client (id)
)
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ENGINE = InnoDB
SQL;

        return $sql;
    }

    /**
     * SQL movement.
     *
     * @return string
     */
    private function sqlMovement(): string
    {
        $sql = <<<SQL
CREATE TABLE movement (
    id INT AUTO_INCREMENT NOT NULL,
    account_id INT NOT NULL,
    type SMALLINT NOT NULL,
    description VARCHAR(150) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    INDEX IDX_F4DD95F79B6B5FBA (account_id),
    PRIMARY KEY(id),
    CONSTRAINT FK_F4DD95F79B6B5FBA
        FOREIGN KEY (account_id)
        REFERENCES account (id)
)
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ENGINE = InnoDB
SQL;

        return $sql;
    }
}
