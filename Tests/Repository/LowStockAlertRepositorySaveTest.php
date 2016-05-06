<?php
namespace Plugin\LowStockAlert\Tests\Repository;

use Plugin\LowStockAlert\Entity\LowStockAlert;
use Eccube\Tests\EccubeTestCase;

/**
* Class test repository
* @author Dung Le
*/
class LowStockAlertRepositorySaveTest extends EccubeTestCase
{
    public function setUp()
    {
        parent::setUp();

        $faker = $this->getFaker();

        $LowStockAlert = new LowStockAlert();
        $LowStockAlert->setId($faker->randomNumber(1));

        $this->app['orm.em']->persist($LowStockAlert);
        $this->app['orm.em']->flush();
    }

    /**
     * Test save function
     *
     */
    public function testSaveLowStockAlert()
    {
        $LowStockAlert = $this->app['eccube.plugin.low_stock_alert.repository.low_stock_alert']->findOneBy(array());
        $LowStockAlert->setId(1);

        $this->app['eccube.plugin.low_stock_alert.repository.low_stock_alert']->save($LowStockAlert);

        $this->assertEquals(1, $LowStockAlert->getId());
    }
}