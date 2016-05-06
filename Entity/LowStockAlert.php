<?php
namespace Plugin\LowStockAlert\Entity;

/**
 * Low stock entity
 */
class LowStockAlert extends \Eccube\Entity\AbstractEntity
{
    
    public function __construct()
    {
    }

    private $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}