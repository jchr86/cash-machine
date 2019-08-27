<?php
/**
 * Created by.
 *
 * User: JCHR <car.chr@gmail.com>
 * Date: 27/08/19
 * Time: 16:06
 */

declare(strict_types=1);

namespace App\Controller;

use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Security Controller.
 *
 * @author JCHR <car.chr@gmail.com>
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->redirectToRoute('app_homepage');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     *
     * @throws RuntimeException
     */
    public function logout(): void
    {
        throw new RuntimeException('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
