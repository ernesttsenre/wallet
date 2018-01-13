<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraints as WalletAssert;

/**
 * @ORM\Entity
 * @ORM\Table(name="transactions")
 * @WalletAssert\TransactionConstraint
 */
class Transaction
{
    const DEBIT = 'debit';
    const CREDIT = 'credit';
    const TRANSFER = 'transfer';

    /**
     * @var array
     */
    private $info = [
        self::DEBIT => [
            'class' => 'success',
            'append' => '+',
        ],
        self::CREDIT => [
            'class' => 'danger',
            'append' => '-',
        ],
        self::TRANSFER => [
            'class' => 'info',
            'append' => null,
        ],
    ];

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Account")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sourceAccount;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Account")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recieverAccount;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $comment;

    /**
     * @var float
     *
     * @ORM\Column(type="float", scale=2, nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var RegistryEntry[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RegistryEntry", mappedBy="transaction", cascade={"remove"})
     */
    private $registryEntries;

    /**
     *
     */
    public function __construct()
    {
        $this->registryEntries = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
    public function getSourceAccount()
    {
        return $this->sourceAccount;
    }

    /**
     * @param Account $sourceAccount
     */
    public function setSourceAccount($sourceAccount)
    {
        $this->sourceAccount = $sourceAccount;
    }

    /**
     * @return Account
     */
    public function getRecieverAccount()
    {
        return $this->recieverAccount;
    }

    /**
     * @param Account $recieverAccount
     */
    public function setRecieverAccount($recieverAccount)
    {
        $this->recieverAccount = $recieverAccount;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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

    /**
     * @return string
     */
    public function getSourceAccountPretty()
    {
        return $this->sourceAccount ?? Account::EMPTY_ACCOUNT;
    }

    /**
     * @return string
     */
    public function getRecieverAccountPretty()
    {
        return $this->recieverAccount ?? Account::EMPTY_ACCOUNT;
    }

    /**
     * @return RegistryEntry[]
     */
    public function getRegistryEntries()
    {
        return $this->registryEntries;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        if ($this->sourceAccount === null) {
            return $this->info[self::DEBIT];
        }

        if ($this->recieverAccount === null) {
            return $this->info[self::CREDIT];
        }

        return $this->info[self::TRANSFER];
    }
}
