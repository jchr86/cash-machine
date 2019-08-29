<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 28/08/19
 * Time: 22:23
 */

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Movement;
use App\Exception\PayCardException;
use App\Form\PayCardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Pay Card Controller.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class PayCardController extends AbstractController
{
    /**
     * @Route("/pagar-tarjeta", name="pay_card")
     *
     * @param Request          $request
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function index(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(PayCardType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $balance = $data['balance'];
            $amount = $data['amount'];

            /** @var Account $account */
            $account = $this->getUser();

            /** @var EntityManagerInterface $em */
            $em = $this->getDoctrine()->getManager();

            $em->getConnection()->beginTransaction();

            try {
                if (!$balance && (empty($amount) || $amount <= 0 || $amount > $account->getBalance())) {
                    throw new PayCardException('Invalid amount.');
                }

                if ($balance) {
                    $amount = $account->getBalance();
                }

                $account->paid($amount);

                $movement = new Movement();
                $movement
                    ->setType(Movement::TYPE_PAY_CARD)
                    ->setAmount($amount)
                    ->setDescription('Pago de tarjeta.')
                ;

                $account->addMovement($movement);
                $em->flush();
                $em->commit();

                $session->set('paid', true);

                return $this->redirectToRoute('pay_card_success');

            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());

                $em->rollback();

                return $this->redirectToRoute('pay_card');
            }
        }

        return $this->render('pay_card/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pagar-tarjeta-exito", name="pay_card_success")
     *
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function success(SessionInterface $session): Response
    {
        if (!$session->has('paid')) {
            return $this->redirectToRoute('pay_card');
        }

        $session->remove('paid');

        return $this->render('pay_card/success.html.twig');
    }
}
