<?php
namespace Plugin\LowStockAlert\Tests\Web;

use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Plugin\LowStockAlert\Entity\LowStockAlert;

/**
* Class test of controller
* @author Dung Le
*/
class LowStockAlertControllerTest extends AbstractAdminWebTestCase
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
     * Create data
     *
     */
    public function createFormData()
    {
        $faker = $this->getFaker();
        $form = array(
            'id' => $faker->randomNumber(1),
            '_token' => 'dummy'
        );
        return $form;
    }

    /**
     * Test routing
     *
     */
    public function testRoutingAdminProductLowStockALert()
    {
        $this->client->request('GET',
            $this->app->url('admin_product_low_stock_alert')
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Test edit
     *
     */
    public function testEditWithPost()
    {
        $formData = $this->createFormData();
        $this->client->request(
            'POST',
            $this->app->url('admin_product_low_stock_alert'),
            array('admin_product_low_stock_alert' => $formData)
        );

        $LowStockAlert = $this->app['eccube.plugin.low_stock_alert.repository.low_stock_alert']->findOneBy(array());
        $this->expected = $formData['id'];
        $this->actual = $LowStockAlert->getId();
        $this->verify();
    }
}