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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Account Controller.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class AccountController extends AbstractController
{
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
