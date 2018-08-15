<?php declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180814233232 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE recipe (id UUID NOT NULL, name VARCHAR(255) NOT NULL, prep_time INT NOT NULL, difficulty INT NOT NULL, vegetarian BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, rate_average DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE TABLE recipe_rate (id UUID NOT NULL, recipe_id UUID NOT NULL, rate INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE recipe');

        $this->addSql('DROP TABLE recipe_rate');
    }
}
