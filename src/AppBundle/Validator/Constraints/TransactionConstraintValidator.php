<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\RegistryEntry;
use AppBundle\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TransactionConstraintValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Transaction $value
     * @param Constraint $constraint
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value->getSourceAccount() === $value->getRecieverAccount()) {
            $this->context->buildViolation('Нельзя использовать одинаковые счета в качестве источника и получателя денег')
                ->addViolation();
        }

        if ($value->getSourceAccount() !== null) {
            $sourceBalance = $this->entityManager->getRepository(RegistryEntry::class)->getAccountBalance($value->getSourceAccount()->getId());
            if ($sourceBalance < $value->getAmount()) {
                $this->context->buildViolation('Не хватает денег на счете для выполнения транзакции')
                    ->addViolation();
            }
        }
    }
}
