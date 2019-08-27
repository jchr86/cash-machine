<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 26/08/19
 * Time: 11:28
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true, unique=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=16, nullable=true, unique=true)
     */
    private $clabe;

    /**
     * @ORM\Column(type="string", length=16, unique=true)
     */
    private $cardNumber;

    /**
     * @ORM\Column(type="smallint")
     */
    private $expiryMonth;

    /**
     * @ORM\Column(type="smallint")
     */
    private $expiryYear;

    /**
     * @ORM\Column(type="smallint")
     */
    private $cvc;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $balance;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movement", mappedBy="account", orphanRemoval=true)
     */
    private $movements;

    /**
     * @ORM\Column(type="smallint")
     */
    private $pin;

    /**
     * Account constructor.
     */
    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     *
     * @return Account
     */
    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClabe(): ?string
    {
        return $this->clabe;
    }

    /**
     * @param string|null $clabe
     *
     * @return Account
     */
    public function setClabe(?string $clabe): self
    {
        $this->clabe = $clabe;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     *
     * @return Account
     */
    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExpiryMonth(): ?int
    {
        return $this->expiryMonth;
    }

    /**
     * @param int $expiryMonth
     *
     * @return Account
     */
    public function setExpiryMonth(int $expiryMonth): self
    {
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getExpiryYear(): ?int
    {
        return $this->expiryYear;
    }

    /**
     * @param int $expiryYear
     *
     * @return Account
     */
    public function setExpiryYear(int $expiryYear): self
    {
        $this->expiryYear = $expiryYear;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCvc(): ?int
    {
        return $this->cvc;
    }

    /**
     * @param int $cvc
     *
     * @return Account
     */
    public function setCvc(int $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     *
     * @return Account
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBalance(): ?string
    {
        return $this->balance;
    }

    /**
     * @param string|null $balance
     *
     * @return Account
     */
    public function setBalance(?string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return Account
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client|null $client
     *
     * @return Account
     */
    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Movement[]
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }

    /**
     * @param Movement $movement
     *
     * @return Account
     */
    public function addMovement(Movement $movement): self
    {
        if (!$this->movements->contains($movement)) {
            $this->movements[] = $movement;
            $movement->setAccount($this);
        }

        return $this;
    }

    /**
     * @param Movement $movement
     *
     * @return Account
     */
    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->contains($movement)) {
            $this->movements->removeElement($movement);
            // set the owning side to null (unless already changed)
            if ($movement->getAccount() === $this) {
                $movement->setAccount(null);
            }
        }

        return $this;
    }

    /**
     *
     * @return int|null
     */
    public function getPin(): ?int
    {
        return $this->pin;
    }

    /**
     * @param int $pin
     *
     * @return Account
     */
    public function setPin(int $pin): self
    {
        $this->pin = $pin;

        return $this;
    }
}
