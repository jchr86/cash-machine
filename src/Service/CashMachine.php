<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 28/08/2019
 * Time: 10:32
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Account;
use App\Exception\WithdrawalException;
use Symfony\Component\Security\Core\Security;

/**
 * CashMachine.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class CashMachine
{
    private static $bills = [50, 100, 200, 500, 1000];

    /** @var int */
    private $remainingAmount;

    /** @var array */
    private $cash;

    /** @var Account */
    private $account;

    /**
     * Cash Machine constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->account = $security->getUser();
    }

    /**
     * Get bills available.
     *
     * @return array
     */
    public static function getBillsAvailable(): array
    {
        return self::$bills;
    }

    /**
     * @param int $amount
     *
     * @return bool
     */
    public function hasSufficientMoney(int $amount): bool
    {
        return $this->account->getAmountAvailable() >= $this->account->getAmountWithCommission($amount);
    }

    /**
     * @param int $amount
     *
     * @return array
     *
     * @throws WithdrawalException
     */
    public function getBills(int $amount): array
    {
        $this->calculateBills($amount);

        if ($this->remainingAmount > 0) {
            throw new WithdrawalException('Invalid amount.');
        }

        return $this->cash;
    }

    /**
     * Get max amount.
     *
     * @return int
     */
    public function getMaxAmount(): int
    {
        $minBill = min(self::$bills);
        $amountAvailable = (int) $this->account->getAmountAvailable();
        $this->calculateBills($amountAvailable);
        $amount = $amountAvailable - $this->remainingAmount;

        while (!$this->hasSufficientMoney($amount)) {
            $amount -= $minBill;
            $this->calculateBills($amount);
            $amount -= $this->remainingAmount;
        }

        return $amount;
    }

    /**
     * Calculate bills.
     *
     * @param int $amount
     */
    private function calculateBills(int $amount): void
    {
        $this->remainingAmount = $amount;
        $this->cash = [];

        $bills = self::$bills;
        rsort($bills);

        foreach ($bills as $bill) {
            $division = (int) floor($this->remainingAmount / $bill);

            if (0 === $division) {
                continue;
            }

            $this->cash[$bill] = $division;
            $this->remainingAmount -= $bill * $division;
        }
    }
}
