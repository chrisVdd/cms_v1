<?php


namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Class LoginFormAuthenticator
 * @package App\Securitys
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    private $userRepository;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;

    /**
     * LoginFormAuthenticator constructor.
     *
     * @param UserRepository $userRepository
     * @param RouterInterface $router
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserRepository $userRepository, RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository   = $userRepository;
        $this->router           = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @inheritDoc
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('app_login');
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'app_login'
            && $request->isMethod('POST');
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        /** @var array $credentials */
        $credentials = [
            'email'         => $request->request->get('email'),
            'password'      => $request->request->get('password'),
            'csrf_token'    => $request->request->get('_csrf_token'),
        ];

        $request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);

        return $credentials;
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        return $this->userRepository->findOneBy(
            ['email' => $credentials['email']]
        );
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {

        if ( in_array('ROLE_ADMIN', $token->getRoleNames()) ) {

            return new RedirectResponse($this->router->generate('admin_index'));
        }

        if ( in_array('ROLE_USER', $token->getRoleNames()) ) {

            return new RedirectResponse($this->router->generate('page_index'));
        }

    }
}