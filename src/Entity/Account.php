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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 *
 * @UniqueEntity("number")
 * @UniqueEntity("clabe")
 * @UniqueEntity("cardNumber")
 */
class Account implements UserInterface
{
    use TimestampableEntity;

    public const TYPE_DEBIT = 1;
    public const TYPE_CREDIT = 2;

    public const CREDIT_COMMISSION_PERCENT = 10;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true, unique=true)
     *
     * @Assert\Length(min="10", max="10")
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=18, nullable=true, unique=true)
     *
     * @Assert\Length(min="18", max="18")
     */
    private $clabe;

    /**
     * @ORM\Column(type="string", length=16, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="16", max="16")
     */
    private $cardNumber;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\GreaterThanOrEqual(1)
     * @Assert\LessThanOrEqual(12)
     */
    private $expiryMonth;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="4")
     * @Assert\Type(type="integer")
     */
    private $expiryYear;

    /**
     * @ORM\Column(type="smallint", length=4)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="4")
     * @Assert\Type(type="integer")
     */
    private $cvc;

    /**
     * @ORM\Column(type="float", precision=10, scale=2)
     *
     * @Assert\Type(type="numeric")
     */
    private $amount;

    /**
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     */
    private $balance;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movement", mappedBy="account", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $movements;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $pin;

    /**
     * Plain pin. Used for model validation. Must not be persisted.
     *
     * @var string
     *
     * @Assert\Length(min="4", max="4")
     * @Assert\Type(type="numeric")
     */
    protected $plainPin;

    /**
     * Account constructor.
     */
    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getCardNumber();
    }

    /**
     * @param ExecutionContextInterface $context
     *
     * @Assert\Callback()
     */
    public function validate(ExecutionContextInterface $context): void
    {
        if (self::TYPE_DEBIT === $this->type) {
            if (empty($this->getNumber())) {
                $context->buildViolation('This value should not be blank.')
                    ->atPath('number')
                    ->addViolation()
                ;
            }

            if (empty($this->getClabe())) {
                $context->buildViolation('This value should not be blank.')
                    ->atPath('clabe')
                    ->addViolation()
                ;
            }
        }

        if (!$this->getId() && empty($this->getPlainPin())) {
            $context->buildViolation('This value should not be blank.')
                ->atPath('plainPin')
                ->addViolation()
            ;
        }
    }

    /**
     * Returns the type list.
     *
     * @return array
     */
    public static function getTypeList(): array
    {
        return [
            'card_debit' => self::TYPE_DEBIT,
            'card_credit' => self::TYPE_CREDIT,
        ];
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
     * @return float|null
     */
    public function getAmountAvailable(): ?float
    {
        $available = $this->amount;

        if (self::TYPE_CREDIT === $this->type) {
            $available -= $this->balance;
        }

        return $available;
    }

    /**
     * Charge.
     *
     * @param float $amount
     *
     * @return Account
     */
    public function charge(float $amount): self
    {
        if (self::TYPE_CREDIT === $this->type) {
            $this->balance += $amount;
        } else {
            $this->amount -= $amount;
        }

        return $this;
    }

    /**
     * Paid.
     *
     * @param float $amount
     *
     * @return Account
     */
    public function paid(float $amount): self
    {
        $this->balance -= $amount;

        return $this;
    }

    /**
     * Deposit.
     *
     * @param float $amount
     *
     * @return Account
     */
    public function deposit(float $amount): self
    {
        $this->amount += $amount;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return Account
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount with commission.
     *
     * @param float $amount
     *
     * @return float|int
     */
    public function getAmountWithCommission(float $amount)
    {
        if (self::TYPE_CREDIT === $this->type) {
            $amount *= (self::CREDIT_COMMISSION_PERCENT / 100) + 1;
        }

        return $amount;
    }

    /**
     * @return float|null
     */
    public function getBalance(): ?float
    {
        return $this->balance;
    }

    /**
     * @param float|null $balance
     *
     * @return Account
     */
    public function setBalance(?float $balance): self
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
     * @return string|null
     */
    public function getPin(): ?string
    {
        return $this->pin;
    }

    /**
     * @param string $pin
     *
     * @return Account
     */
    public function setPin(string $pin): self
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get Plain Pin.
     *
     * @return string|null
     */
    public function getPlainPin(): ?string
    {
        return $this->plainPin;
    }

    /**
     * Set Plain Pin.
     *
     * @param string|null $plainPin
     *
     * @return Account
     */
    public function setPlainPin(?string $plainPin): Account
    {
        $this->plainPin = $plainPin;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return (string) $this->cardNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): string
    {
        return (string) $this->pin;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->cvc = null;
    }
}
