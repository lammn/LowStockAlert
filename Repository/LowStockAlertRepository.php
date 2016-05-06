<?php
namespace Plugin\LowStockAlert\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Doctrine ORM entity
 * @author Dung Le
 */
class LowStockAlertRepository extends EntityRepository
{
    /**
     * Save function
     * @param  \Plugin\LowStockAlert\Entity\LowStockAlert $LowStockAlert
     * @return bool
     */
    public function save(\Plugin\LowStockAlert\Entity\LowStockAlert $LowStockAlert)
    {
        $this->_em->getConnection()->beginTransaction();
        try {
            $this->_em->persist($LowStockAlert);
            $this->_em->flush();

            $this->_em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->_em->getConnection()->rollback();

            return false;
        }
        return true;
    }
}
