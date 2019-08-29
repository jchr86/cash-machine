<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 28/08/19
 * Time: 09:08
 */

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Movement;
use App\Exception\WithdrawalException;
use App\Form\CashWithdrawalType;
use App\Service\CashMachine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Account Controller.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/retiro-efectivo", name="cash_withdrawal")
     *
     * @param Request          $request
     * @param SessionInterface $session
     * @param CashMachine      $cashMachine
     *
     * @return Response
     */
    public function cashWithdrawal(Request $request, SessionInterface $session, CashMachine $cashMachine): Response
    {
        $form = $this->createForm(CashWithdrawalType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $amount = (int) $form->get('amount')->getData();

            /** @var EntityManagerInterface $em */
            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();

            try {
                if (!$cashMachine->hasSufficientMoney($amount)) {
                    throw new WithdrawalException('You do not have enough money.');
                }

                $bills = $cashMachine->getBills($amount);

                /** @var Account $account */
                $account = $this->getUser();

                $amountWithCommission = $account->getAmountWithCommission($amount);
                $account->charge($amountWithCommission);

                $movement = new Movement();
                $movement
                    ->setType(Movement::TYPE_CASH_WITHDRAWAL)
                    ->setAmount($amountWithCommission)
                    ->setDescription('Retiro en efectivo.')
                ;

                $account->addMovement($movement);
                $em->flush();
                $em->commit();

                $session->set('bills', $bills);
                $session->set('amount', $amount);

                return $this->redirectToRoute('cash_withdrawal_success');
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());

                $em->rollback();

                return $this->redirectToRoute('cash_withdrawal');
            }
        }

        return $this->render('account/cash_withdrawal.html.twig', [
            'form' => $form->createView(),
            'maxAmount' => $cashMachine->getMaxAmount(),
        ]);
    }

    /**
     * @Route("/retiro-efectivo-exito", name="cash_withdrawal_success")
     *
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function cashWithdrawalSuccess(SessionInterface $session): Response
    {
        if (!$session->has('bills')) {
            return $this->redirectToRoute('cash_withdrawal');
        }

        $bilss = $session->get('bills');
        $amount = $session->get('amount');

        $session->remove('bills');
        $session->remove('amount');

        /** @var Account $account */
        $account = $this->getUser();
        $amountWithCommission = $account->getAmountWithCommission($amount);

        return $this->render('account/cash_withdrawal_success.html.twig', [
            'bills' => $bilss,
            'amount' => $amount,
            'amountWithCommission' => $amountWithCommission,
        ]);
    }

    /**
     * @Route("/balance", name="balance")
     *
     * @return Response
     */
    public function balance(): Response
    {
        return $this->render('account/balance.html.twig');
    }
}
