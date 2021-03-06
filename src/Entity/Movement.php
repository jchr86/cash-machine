<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 26/08/19
 * Time: 11:34
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovementRepository")
 */
class Movement
{
    use TimestampableEntity;

    public const TYPE_CASH_WITHDRAWAL = 1;
    public const TYPE_PAY_CARD = 2;
    public const TYPE_CASH_DEPOSIT = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="movements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * Id.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * Returns the type list.
     *
     * @return array
     */
    public static function getTypeList(): array
    {
        return [
            'movement_cash_withdrawal' => self::TYPE_CASH_WITHDRAWAL,
            'movement_pay_card' => self::TYPE_PAY_CARD,
            'movement_cash_deposit' => self::TYPE_CASH_DEPOSIT,
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
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return Movement
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Movement
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param Account|null $account
     *
     * @return Movement
     */
    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Get amount format.
     *
     * @return string
     */
    public function getAmountFormat(): string
    {
        return number_format($this->amount, 2);
    }

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return Movement
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
