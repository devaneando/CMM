<?php

namespace App\Controller;

use App\Traits\ExceptionLoggerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /** @var AuthorizationChecker */
    private $securityContext;

    use ExceptionLoggerTrait;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->securityContext = $authorizationChecker;
    }

    /**
     * Disable root path.
     *
     * @Route("/", name="root")
     *
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     */
    public function homeAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('sonata_admin_dashboard');
        }

        return $this->redirectToRoute('user_login');
    }

    /**
     * User login.
     *
     * @Route("/user/login", name="user_login")
     *
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        try {
            if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
                return $this->redirectToRoute('sonata_admin_dashboard');
            }

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);
        } catch (\Exception $ex) {
            $this->logException($ex);
        }
    }
}
