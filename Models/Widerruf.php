<?php

namespace LandolsiWiderrufsbutton\Models;

use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\ModelEntity;

/**
 * Stored record of a submitted right-of-withdrawal declaration (§ 356a BGB).
 * Kept for documentation / proof that the declaration was received.
 *
 * @ORM\Entity()
 * @ORM\Table(name="s_plugin_landolsi_widerruf")
 */
class Widerruf extends ModelEntity
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * Order number / contract identifier (Bestell-/Vertragskennung).
     *
     * @var string|null
     * @ORM\Column(name="order_number", type="string", length=255, nullable=true)
     */
    private $orderNumber;

    /**
     * Free text identifying the contract (or the part) the customer withdraws from.
     *
     * @var string|null
     * @ORM\Column(name="contract_info", type="text", nullable=true)
     */
    private $contractInfo;

    /**
     * @var int|null
     * @ORM\Column(name="customer_id", type="integer", nullable=true)
     */
    private $customerId;

    /**
     * @var int|null
     * @ORM\Column(name="shop_id", type="integer", nullable=true)
     */
    private $shopId;

    /**
     * IP address at the time of the declaration (proof of submission).
     *
     * @var string|null
     * @ORM\Column(name="ip_address", type="string", length=64, nullable=true)
     */
    private $ipAddress;

    /**
     * @var bool
     * @ORM\Column(name="confirmation_sent", type="boolean", nullable=false)
     */
    private $confirmationSent = false;

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function getContractInfo()
    {
        return $this->contractInfo;
    }

    public function setContractInfo($contractInfo)
    {
        $this->contractInfo = $contractInfo;
        return $this;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function getShopId()
    {
        return $this->shopId;
    }

    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
        return $this;
    }

    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    public function getConfirmationSent()
    {
        return $this->confirmationSent;
    }

    public function setConfirmationSent($confirmationSent)
    {
        $this->confirmationSent = (bool) $confirmationSent;
        return $this;
    }
}
