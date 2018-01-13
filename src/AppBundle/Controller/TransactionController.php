<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
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

        $categoryId = $this->get('request_stack')->getCurrentRequest()->get('categoryId');
        if ($categoryId !== null) {
            /** @var Category $category */
            $category = $this->get('doctrine.orm.default_entity_manager')->getRepository(Category::class)->find($categoryId);
            $transaction->setCategory($category);

            if ($category->isFromWorld()) {
                $transaction->setSourceAccount(null);
            }

            if ($category->isToWorld()) {
                $transaction->setRecieverAccount(null);
            }

            if ($category->getDefaultComment() !== null) {
                $transaction->setComment($category->getDefaultComment());
            }

            if ($category->getDefaultAmount() !== null) {
                $transaction->setAmount($category->getDefaultAmount());
            }
        }

        return $transaction;
    }

    /**
     * @param Transaction $entity
     * @param array $entityProperties
     * @return \Symfony\Component\Form\Form
     */
    public function createTransactionNewForm($entity, array $entityProperties)
    {
        $newForm = parent::createNewForm($entity, $entityProperties);

        $categoryId = $this->get('request_stack')->getCurrentRequest()->get('categoryId');
        if ($categoryId !== null) {
            /** @var Category $category */
            $category = $this->get('doctrine.orm.default_entity_manager')->getRepository(Category::class)->find($categoryId);
            $newForm->remove('category');

            if ($category->isFromWorld() || $category->isToWorld()) {
                if ($category->isFromWorld()) {
                    $newForm->remove('sourceAccount');
                } else {
                    $newForm->remove('recieverAccount');
                }
            }

            if ($category->getDefaultComment() !== null) {
                $newForm->remove('comment');
            }
        }

        return $newForm;
    }
}
