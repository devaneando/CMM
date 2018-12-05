<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/user")
 */
class SecurityController extends Controller
{
    /** @var AuthorizationChecker */
    private $securityContext;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->securityContext = $authorizationChecker;
    }

    /**
     * Disable basic route.
     *
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     */
    public function homeAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
    }

    /**
     * User login.
     *
     * @Route("/login", name="user_login")
     *
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}
