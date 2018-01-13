<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Account;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class RegistryEntityRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    private function getBalanceQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('registry_entity')
            ->select([
                'account.id',
                'SUM(registry_entity.debitAmount - registry_entity.creditAmount) as amount'
            ])
            ->join(Account::class, 'account', 'WITH', 'account.id = registry_entity.account')
            ->groupBy('account.id');
    }

    /**
     * @return array
     */
    public function getAccountBalances(): array
    {
        $balances = $this->getBalanceQueryBuilder()
            ->getQuery()
            ->getResult();

        $items = [];
        foreach ($balances as $balance) {
            $items[$balance['id']] = $balance;
        }

        return $items;
    }

    /**
     * @param int $accountId
     * @return float
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getAccountBalance(int $accountId)
    {
        return (float)$this->getBalanceQueryBuilder()
            ->select('SUM(registry_entity.debitAmount - registry_entity.creditAmount)')
            ->andWhere('registry_entity.account = :accountId')
                ->setParameter('accountId', $accountId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
