<?php

namespace App\Security\Voter;

use App\Entity\Applicant;
use App\Entity\ApplicantCv;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ApplicantCvVoter extends Voter
{
    public const APPLICANT_CV_EXISTS = 'APPLICANT_CV_EXISTS';
    public const APPLICANT_CV_HAS_ACCESS = 'APPLICANT_CV_HAS_ACCESS';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::APPLICANT_CV_EXISTS, self::APPLICANT_CV_HAS_ACCESS]);
    }

    /** @param ApplicantCv $subject */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var Applicant $user */
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::APPLICANT_CV_EXISTS => $user->getCv() !== null,
            self::APPLICANT_CV_HAS_ACCESS => $subject->getId() === $user->getCv()->getId(), // TODO: allow recruiters as well
            default => false,
        };
    }
}
