<?php
/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarum\Github;

use Flarum\Support\Action;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
use Illuminate\Contracts\Bus\Dispatcher;
use Flarum\Core\Settings\SettingsRepository;
use Flarum\Http\UrlGeneratorInterface;
use League\OAuth2\Client\Provider\Github;
use Flarum\Forum\Actions\AuthenticatorTrait;

class LoginAction extends Action
{
    use AuthenticatorTrait;

    /**
     * @var SettingsRepository
     */
    protected $settings;

    /**
     * @var UrlGeneratorInterface
     */
    protected $url;

    /**
     * @param SettingsRepository $settings
     * @param UrlGeneratorInterface $url
     * @param Dispatcher $bus
     */
    public function __construct(SettingsRepository $settings, UrlGeneratorInterface $url, Dispatcher $bus)
    {
        $this->settings = $settings;
        $this->url = $url;
        $this->bus = $bus;
    }

    /**
     * @param Request $request
     * @param array $routeParams
     * @return RedirectResponse|EmptyResponse
     */
    public function handle(Request $request, array $routeParams = [])
    {
        session_start();

        $provider = new Github([
            'clientId'     => $this->settings->get('github.client_id'),
            'clientSecret' => $this->settings->get('github.client_secret'),
            'redirectUri'  => $this->url->toRoute('github.login')
        ]);

        if (! isset($_GET['code'])) {
            $authUrl = $provider->getAuthorizationUrl([
                'scope' => ['user:email']
            ]);
            $_SESSION['oauth2state'] = $provider->getState();

            return new RedirectResponse($authUrl);
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            echo 'Invalid state.';
            exit;
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        $owner = $provider->getResourceOwner($token);

        $email = $owner->getEmail();
        $username = preg_replace('/[^a-z0-9-_]/i', '', $owner->getNickname());

        return $this->authenticated(compact('email'), compact('username'));
    }
}
