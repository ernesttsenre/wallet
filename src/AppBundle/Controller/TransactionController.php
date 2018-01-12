<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Transaction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class TransactionController extends BaseAdminController
{
    /**
     * @return Transaction
     */
    protected function createNewTransactionEntity()
    {
        $transaction = new Transaction();
        $transaction->setUser($this->getUser());
        $transaction->setCreatedAt(new \DateTime());

        return $transaction;
    }
}
