<?php

namespace App\Security\Voter;

use App\Entity\Applicant;
use App\Entity\JobOffer;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class JobOfferVoter extends Voter
{
    public const JOB_OFFER_USER_HAS_APPLIED = 'JOB_OFFER_USER_HAS_APPLIED';
    public const JOB_OFFER_USER_CAN_APPLY = 'JOB_OFFER_USER_CAN_APPLY';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::JOB_OFFER_USER_HAS_APPLIED, self::JOB_OFFER_USER_CAN_APPLY])
            && $subject instanceof \App\Entity\JobOffer;
    }


    /** @param JobOffer $subject */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var Applicant $user */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::JOB_OFFER_USER_HAS_APPLIED => $subject->getApplicants()->contains($user),
            self::JOB_OFFER_USER_CAN_APPLY => !$subject->getApplicants()->contains($user),
            default => false,
        };

    }
}
