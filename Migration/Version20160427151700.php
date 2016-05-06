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
    public function up(Schema $schema)
    {
        $this->createPluginTable($schema);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('plg_low_stock_alert');
    }

    protected function createPluginTable(Schema $schema)
    {
        $table = $schema->createTable("plg_low_stock_alert");
        $table->addColumn('stock_alert', 'integer', array(
            'unsigned' => true,
            'default' => 0,
        ));
        $table->setPrimaryKey(array('stock_alert'));
    }
}