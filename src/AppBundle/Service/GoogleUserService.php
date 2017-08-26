<?php

namespace AppBundle\Service;

//use AppBundle\Entity\Group;
//use AppBundle\Entity\Person;
//use AppBundle\Entity\Scout;
//use AppBundle\Entity\Talent;
//use AppBundle\Entity\TalentStatusHistory;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
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

//    /**
//     * @var Group
//     */
//    private $adminGroup;
//
//    /**
//     * @var Group
//     */
//    private $scoutGroup;
//
//    /**
//     * @var Group
//     */
//    private $talentGroup;

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

//        $this->adminGroup = $this->entityManager->getRepository('AppBundle:Group')->findOneBy(['role' => 'ROLE_ADMIN']);
//        $this->scoutGroup = $this->entityManager->getRepository('AppBundle:Group')->findOneBy(['role' => 'ROLE_SCOUT']);
//        $this->talentGroup = $this->entityManager->getRepository('AppBundle:Group')->findOneBy(['role' => 'ROLE_TALENT']);
    }

    /**
     * Get googleService.
     *
     * @return GoogleService
     */
    public function getGoogleService()
    {
        return $this->googleService;
    }

//    /**
//     * Get all users from provided domain.
//     *
//     * @param $domain
//     *
//     * @throws \Doctrine\ORM\OptimisticLockException
//     * @throws \Doctrine\ORM\ORMInvalidArgumentException
//     * @throws \Exception
//     */
//    public function getAllUsers($domain)
//    {
//        $this->googleService->auth(GoogleService::SERVICE);
//        $this->googleService->getClient()->setSubject($this->googleService->getAdminUser());
//
//        $service = new \Google_Service_Directory($this->googleService->getClient());
//
//        /** @var \Google_Service_Directory_Users $users */
//        $users = $service->users->listUsers(['domain' => $domain])->getUsers();
//
//        /** @var \Google_Service_Directory_User $user */
//        foreach ($users as $user) {
//            $dbUser = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['googleId' => $user->getId()]);
//
//            if (!$dbUser) {
//                $dbUser = new User($this->createPerson($user), $user->getId(), $user->getPrimaryEmail());
//                $this->entityManager->persist($dbUser);
//                $this->entityManager->flush();
//            }
//
//            $this->updateUser($dbUser, $user);
//        }
//    }
//
//    /**
//     * Update user.
//     *
//     * @param User                           $user
//     * @param \Google_Service_Directory_User $googleUser
//     *
//     * @throws \Doctrine\ORM\OptimisticLockException
//     * @throws \Doctrine\ORM\ORMInvalidArgumentException
//     */
//    private function updateUser(User $user, \Google_Service_Directory_User $googleUser)
//    {
//        $this->updateUserGroups($user, $googleUser->getOrgUnitPath());
//
//        if ($user->getGroups()->contains($this->scoutGroup)) {
//            $scout = $user->getPerson()->getScout();
//
//            if (!$scout) {
//                $scout = new Scout($user->getPerson());
//
//                $this->entityManager->persist($scout);
//            }
//        }
//
//        if ($user->getGroups()->contains($this->talentGroup)) {
//            $talent = $user->getPerson()->getTalent();
//
//            if (!$talent) {
//                $talent = new Talent($user->getPerson());
//
//                $this->entityManager->persist($talent);
//                $this->entityManager->flush();
//
//                $talentStatusHistory = new TalentStatusHistory($talent, Talent::ACTIVE);
//
//                $this->entityManager->persist($talentStatusHistory);
//            }
//        }
//
//        $this->entityManager->flush();
//    }
//
//    /**
//     * Set group based on Google organisation unit.
//     *
//     * @param User   $user
//     * @param string $organisationUnit
//     *
//     * @throws \Doctrine\ORM\ORMInvalidArgumentException
//     */
//    public function updateUserGroups(User $user, string $organisationUnit)
//    {
//        $group = null;
//        $userGroups = (!$user->getGroups() ? new ArrayCollection() : $user->getGroups());
//
//        if ('/Support' === $organisationUnit && !$userGroups->contains($this->adminGroup)) {
//            $group = $this->adminGroup;
//        } elseif ('/Scouts' === $organisationUnit && !$userGroups->contains($this->scoutGroup)) {
//            $group = $this->scoutGroup;
//        } elseif ('/ict-campus/ICT Talents' === $organisationUnit && !$userGroups->contains($this->talentGroup)) {
//            $group = $this->talentGroup;
//        }
//
//        if ($group) {
//            $user->addGroup($group);
//            $this->entityManager->persist($user);
//        }
//    }
//
//    /**F
//     * Create person object.
//     *
//     * @param \Google_Service_Directory_User $googleUser
//     *
//     * @throws \Doctrine\ORM\OptimisticLockException
//     * @throws \Doctrine\ORM\ORMInvalidArgumentException
//     *
//     * @return Person
//     */
//    private function createPerson(\Google_Service_Directory_User $googleUser)
//    {
//        $name = $googleUser->getName();
//
//        /** @var Person $person */
//        $person = new Person($name->getFamilyName(), $name->getGivenName());
//        $person->setMail($googleUser->getPrimaryEmail());
//
//        $this->entityManager->persist($person);
//        $this->entityManager->flush();
//
//        return $person;
//    }
//
//    /**
//     * Update AccessToken data.
//     *
//     * @param int   $googleId
//     * @param array $accessToken =null
//     *
//     * @throws \Doctrine\ORM\OptimisticLockException
//     * @throws \Doctrine\ORM\ORMInvalidArgumentException
//     * @throws \Exception
//     *
//     * @return bool
//     */
//    public function updateUserAccessToken($googleId, array $accessToken = null): bool
//    {
//        /** @var User $user */
//        $user = $this->entityManager->getRepository('AppBundle:User')->findOneBy(['googleId' => $googleId]);
//
//        if ($user) {
//            if ($accessToken) {
//                $user->setAccessToken($accessToken['access_token']);
//                $user->setAccessTokenExpire(
//                    (new \DateTime())->add(new \DateInterval('PT'.($accessToken['expires_in'] - 5).'S'))
//                );
//
//                $this->entityManager->persist($user);
//                $this->entityManager->flush();
//            }
//
//            return true;
//        }
//
//        return false;
//    }
}
