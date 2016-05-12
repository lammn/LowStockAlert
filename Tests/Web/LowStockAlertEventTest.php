<?php
/**
 * Created by PhpStorm.
 * User: lqdung
 * Date: 5/12/2016
 * Time: 10:43 AM
 */

namespace Plugin\LowStockAlert\Tests\Web;

use Eccube\Tests\Web\AbstractWebTestCase;

class LowStockAlertEventTest extends AbstractWebTestCase
{
    public function testOnRenderProductsDetailBefore()
    {
        try{
            $crawler = $this->client->request('GET', $this->app->url('product_detail', array('id' => 1)));
            $crawler->filter('#item_detail_area .extra-form')->text();
            $this->assertTrue(true);
        }catch(\InvalidArgumentException $e){
            $this->assertTrue(false);
        }
    }
}
