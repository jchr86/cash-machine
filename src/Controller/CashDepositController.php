<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 28/08/19
 * Time: 23:59
 */

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Movement;
use App\Form\CashDepositType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cash Deposit Controller.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class CashDepositController extends AbstractController
{
    /**
     * @Route("/deposito-efectivo", name="cash_deposit")
     *
     * @param Request          $request
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function index(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(CashDepositType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $amount = $form->get('amount')->getData();

            /** @var Account $account */
            $account = $this->getUser();

            /** @var EntityManagerInterface $em */
            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();

            try {
                $account->deposit($amount);

                $movement = new Movement();
                $movement
                    ->setType(Movement::TYPE_CASH_DEPOSIT)
                    ->setAmount($amount)
                    ->setDescription('Depósito en efectivo.')
                ;

                $account->addMovement($movement);
                $em->flush();
                $em->commit();

                $session->set('deposit', true);

                return $this->redirectToRoute('cash_deposit_success');
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());

                $em->rollback();

                return $this->redirectToRoute('cash_deposit');
            }
        }

        return $this->render('cash_deposit/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deposito-efectivo-exito", name="cash_deposit_success")
     *
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function success(SessionInterface $session): Response
    {
        if (!$session->has('deposit')) {
            return $this->redirectToRoute('cash_deposit');
        }

        $session->remove('deposit');

        return $this->render('cash_deposit/success.html.twig');
    }
}
