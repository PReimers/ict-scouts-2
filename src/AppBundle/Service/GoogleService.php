<?php

namespace AppBundle\Service;

use Google_Client;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class GoogleService.
 */
class GoogleService
{
    const USER = 'user';
    const SERVICE = 'service';

    /**
     * @var array
     */
    private $userScopes = [
        \Google_Service_Oauth2::USERINFO_PROFILE,
        \Google_Service_Oauth2::USERINFO_EMAIL,
    ];

    /**
     * @var array
     */
    private $serviceScopes = [
        \Google_Service_Directory::ADMIN_DIRECTORY_USER_READONLY,
        \Google_Service_Directory::ADMIN_DIRECTORY_GROUP_READONLY,
    ];

    /**
     * @var Google_Client
     */
    private $client;

    /**
     * @var ParameterBagInterface
     */
    private $parameters;

    /**
     * @var string
     */
    private $adminMail;

    /**
     * GoogleService constructor.
     *
     * @param KernelInterface $kernel
     * @param FileLocator     $locator
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(KernelInterface $kernel, FileLocator $locator)
    {
        if (!getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
            putenv(
                'GOOGLE_APPLICATION_CREDENTIALS='.realpath($locator->locate(
                    'config/client_secret.json'
                ))
            );
        }

        $this->parameters = $kernel->getContainer()->getParameterBag();
        $this->adminMail = $this->parameters->get('google_apps_admin');
        $this->client = new Google_Client();
    }

    /**
     * Set Authentication parameters for any API request.
     *
     * @param string $type GoogleService::USER oder GoogleService::SERVICE
     *
     * @throws \Exception
     *
     * @return Google_Client
     */
    public function auth(string $type): Google_Client
    {
        if (self::USER !== $type && self::SERVICE !== $type) {
            throw new \Exception('Connection type must be "'.self::USER.'" or "'.self::SERVICE.'".');
        }

        switch ($type) {
            case self::SERVICE:
                $this->client->useApplicationDefaultCredentials();
                $this->setScope(self::SERVICE);
                break;
            case self::USER:
                $this->client->setApplicationName($this->parameters->get('google_app_name'));
                $this->client->setClientId($this->parameters->get('google_client_id'));
                $this->client->setClientSecret($this->parameters->get('google_client_secret'));
                $this->client->setRedirectUri($this->parameters->get('google_redirect_uri'));
                $this->client->setDeveloperKey($this->parameters->get('google_developer_key'));
                $this->setScope(self::USER);
                break;
        }

        return $this->client;
    }

    /**
     * Get the user scopes.
     *
     * @return array
     */
    public function getUserScopes(): array
    {
        return $this->userScopes;
    }

    /**
     * Get the service scopes.
     *
     * @return array
     */
    public function getServiceScopes(): array
    {
        return $this->serviceScopes;
    }

    /**
     * @return Google_Client
     */
    public function getClient(): Google_Client
    {
        return $this->client;
    }

    /**
     * Initialize the client.
     *
     * @param string $scope
     *
     * @return Google_Client
     */
    public function setScope($scope): Google_Client
    {
        if ( $scope === self::SERVICE ) {
            $this->client->addScope( $this->getServiceScopes() );
        } else {
            $this->client->addScope( $this->getUserScopes() );
        }

        return $this->client;
    }

    /**
     * Get the G Suite admin user.
     *
     * @return string
     */
    public function getAdminUser(): string
    {
        return $this->adminMail;
    }

    /**
     * Get Google config from parameter bag.
     *
     * @return array
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException
     */
    public function getGoogleConfig() : array
    {
        return [
            'app_name' => $this->parameters->get('google_app_name'),
            'client_id' => $this->parameters->get('google_client_id'),
            'client_secret' => $this->parameters->get('google_client_secret'),
            'redirect_uri' => $this->parameters->get('google_redirect_uri'),
            'developer_key' => $this->parameters->get('google_developer_key'),
            'site_name' => $this->parameters->get('google_site_name'),
            'apps_domain' => $this->parameters->get('google_apps_domain'),
            'apps_admin' => $this->parameters->get('google_apps_admin'),
        ];
    }
}
