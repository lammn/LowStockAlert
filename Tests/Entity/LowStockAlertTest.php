<?php

namespace Plugin\LowStockAlert\Tests\Entity;

use Plugin\LowStockAlert\Entity\LowStockAlert;
use Eccube\Tests\EccubeTestCase;

/**
 * Plugin Entity Test
 *
 * @author Dung Le
 */
class LowStockAlertTest extends EccubeTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testConstructor()
    {
        $LowStockAlert = new LowStockAlert();

        $this->expected = 0;

        $this->actual = $LowStockAlert->getId();
        $this->verify();
    }

    public function testSetId()
    {
        $LowStockAlert = new LowStockAlert();

        $this->expected = 1;

        $LowStockAlert->setId($this->expected);

        $this->actual = $LowStockAlert->getId();
        $this->verify();
    }
}
