<?php

namespace AppBundle\Service;

use AppBundle\Entity\Person;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class GoogleUserService.
 */
class GoogleUserService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var GoogleService
     */
    private $googleService;

    /**
     * GoogleUserService constructor.
     *
     * @param KernelInterface $kernel
     * @param EntityManagerInterface $entityManager
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function __construct(KernelInterface $kernel, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->googleService = $kernel->getContainer()->get(GoogleService::class);
    }

    /**
     * Get googleService.
     *
     * @return GoogleService
     */
    public function getGoogleService(): GoogleService
    {
        return $this->googleService;
    }

    /**
     * Get all users from provided domain.
     *
     * @param $domain
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Exception
     */
    public function getAllUsers($domain): void
    {
        $this->googleService->auth(GoogleService::SERVICE);
        $this->googleService->getClient()->setSubject($this->googleService->getAdminUser());

        $service = new \Google_Service_Directory($this->googleService->getClient());

        /** @var \Google_Service_Directory_Users $users */
        $users = $service->users->listUsers(['domain' => $domain])->getUsers();

        /** @var \Google_Service_Directory_User $user */
        foreach ($users as $user) {
            $dbUser = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['googleId' => $user->getId()]);

            if (!$dbUser) {
                $this->createUser($user);
            }

        }
        $this->entityManager->flush();
    }

    /**
     * Creates a new User and returns the User-Object.
     *
     * @param \Google_Service_Directory_User $googleUser
     *
     * @return User
     */
    public function createUser(\Google_Service_Directory_User $googleUser): User
    {
        $user = new User();
        $user->setGoogleId($googleUser->getId());
        $user->setEmail($googleUser->getPrimaryEmail());
        $this->entityManager->persist($user);

        $person = new Person($googleUser->getName()->getFamilyName(), $googleUser->getName()->getGivenName(), null, null, $googleUser->getPrimaryEmail());
        $person->setUser($user);
        $this->entityManager->persist($person);
        $user->setPerson($person);

        return $user;
    }

    /**
     * Get Google Service Directory User Object for a given Google User ID.
     *
     * @param $googleUserId
     *
     * @return \Google_Service_Directory_User
     * @throws \Exception
     */
    public function getGoogleUser($googleUserId): \Google_Service_Directory_User
    {
        $serviceClient = clone $this->googleService;
        $serviceClient->auth(GoogleService::SERVICE);
        $serviceClient->getClient()->setSubject($this->googleService->getAdminUser());

        $service = new \Google_Service_Directory($serviceClient->getClient());

        return $service->users->get($googleUserId);
    }

}
