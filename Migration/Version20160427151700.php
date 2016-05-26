<?php
namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration: create/delete table
 * @author Dung Le
 */
class Version20160427151700 extends AbstractMigration
{
    const TABLE = 'plg_low_stock_alert';
    public function up(Schema $schema)
    {
        $this->createPluginTable($schema);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable(self::TABLE);
    }

    protected function createPluginTable(Schema $schema)
    {
        $table = $schema->createTable(self::TABLE);
        $table->addColumn('stock_alert', 'integer', array(
            'unsigned' => true,
            'default' => 0,
        ));
        $table->setPrimaryKey(array('stock_alert'));
    }
}