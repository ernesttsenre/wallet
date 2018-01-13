<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistryEntityRepository")
 * @ORM\Table(name="registry_entries",
 *  uniqueConstraints={
 *     @UniqueConstraint(name="registry_entry_unique",
 *          columns={"transaction_id", "user_id", "account_id", "debit_amount", "credit_amount"})
 *    }
 * )
 */
class RegistryEntry
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Transaction
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transaction", inversedBy="registryEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transaction;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Account")
     * @ORM\JoinColumn(nullable=true)
     */
    private $account;

    /**
     * @var float
     *
     * @ORM\Column(type="float", scale=2, nullable=false, options={"default"=0})
     */
    private $debitAmount;

    /**
     * @var float
     *
     * @ORM\Column(type="float", scale=2, nullable=false, options={"default"=0})
     */
    private $creditAmount;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param Transaction $transaction
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return float
     */
    public function getDebitAmount()
    {
        return $this->debitAmount;
    }

    /**
     * @param float $debitAmount
     */
    public function setDebitAmount($debitAmount)
    {
        $this->debitAmount = $debitAmount;
    }

    /**
     * @return float
     */
    public function getCreditAmount()
    {
        return $this->creditAmount;
    }

    /**
     * @param float $creditAmount
     */
    public function setCreditAmount($creditAmount)
    {
        $this->creditAmount = $creditAmount;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
