<?php

// src/Security/UserProvider.php
namespace App\Security;

use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{

    public function __construct(private readonly ParticipantRepository $repository) {}
    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me. If you're not using these features, you do not
     * need to implement this method.
     *
     * @throws UserNotFoundException if the user is not found
     */

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        // Création de la requête pour récupérer l'utilisateur par email ou pseudo
        $qb = $this->repository->createQueryBuilder('u');
        $qb->where('u.email = :identifier')
            ->orWhere('u.pseudo = :identifier')
            ->setParameter('identifier', $identifier);

        // Exécution de la requête
        $user = $qb->getQuery()->getOneOrNullResult();

        if (!$user) {
            throw new UserNotFoundException('User not found.');
        }

        return $user;
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof Participant) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        // if (!$user->isActif()) {
        //     throw new \Exception('User is not actif.');
        // }

        return $user;

        // Return a User object after making sure its data is "fresh".
        // Or throw a UserNotFoundException if the user no longer exists.
        throw new \Exception('TODO: fill in refreshUser() inside ' . __FILE__);
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class): bool
    {
        return Participant::class === $class || is_subclass_of($class, Participant::class);
    }

    /**
     * Upgrades the hashed password of a user, typically for using a better hash algorithm.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: when hashed passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newHashedPassword);
    }
}
