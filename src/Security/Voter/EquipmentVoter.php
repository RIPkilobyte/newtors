<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Equipment;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class EquipmentVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])
            && $subject instanceof Equipment;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            $vote?->addReason('The user must be logged in to access this resource.');

            return false;
        }

        /** @var Equipment $equipment */
        $equipment = $subject;

        // Админ может все
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        // Редактор справочников не может редактировать технику, только смотреть
        if (in_array('ROLE_EDITOR', $user->getRoles())) {
            return $attribute === self::VIEW;
        }

        // Просмотр всего
        if (in_array('ROLE_VIEWER', $user->getRoles())) {
            return $attribute === self::VIEW;
        }

        // Админ района
        if (in_array('ROLE_RAION_ADMIN', $user->getRoles())) {
            if ($user->getRaion() && $equipment->getRaion() === $user->getRaion()) {
                return true;
            }
            return false;
        }

        // Просмотр района
        if (in_array('ROLE_RAION_VIEWER', $user->getRoles())) {
            if ($user->getRaion() && $equipment->getRaion() === $user->getRaion()) {
                return $attribute === self::VIEW;
            }
            return false;
        }

        return false;
    }
}
