<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Validator\Constraints as WalletAssert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 * @WalletAssert\CategoryConstraint
 */
class Category
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
        ],
        self::CREDIT => [
            'class' => 'danger',
        ],
        self::TRANSFER => [
            'class' => 'info',
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
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $defaultComment;

    /**
     * @ORM\Column(type="float", scale=2, nullable=true)
     */
    private $defaultAmount;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $fromWorld = false;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $toWorld = true;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, options={"default": "tags"})
     */
    private $icon = 'tags';

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDefaultComment()
    {
        return $this->defaultComment;
    }

    /**
     * @param string $defaultComment
     */
    public function setDefaultComment($defaultComment)
    {
        $this->defaultComment = $defaultComment;
    }

    /**
     * @return mixed
     */
    public function getDefaultAmount()
    {
        return $this->defaultAmount;
    }

    /**
     * @param mixed $defaultAmount
     */
    public function setDefaultAmount($defaultAmount)
    {
        $this->defaultAmount = $defaultAmount;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return bool
     */
    public function isFromWorld()
    {
        return $this->fromWorld;
    }

    /**
     * @param bool $fromWorld
     */
    public function setFromWorld($fromWorld)
    {
        $this->fromWorld = $fromWorld;
    }

    /**
     * @return bool
     */
    public function isToWorld()
    {
        return $this->toWorld;
    }

    /**
     * @param bool $toWorld
     */
    public function setToWorld($toWorld)
    {
        $this->toWorld = $toWorld;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        if (!$this->toWorld && !$this->fromWorld) {
            return $this->info[self::TRANSFER];
        }

        if ($this->fromWorld) {
            return $this->info[self::DEBIT];
        }

        if ($this->toWorld) {
            return $this->info[self::CREDIT];
        }
    }
}
