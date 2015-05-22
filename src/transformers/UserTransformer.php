<?php
namespace Tap\Transformers;

use League\Fractal\TransformerAbstract;
use Craft\UserModel;
use Craft\Craft;

class UserTransformer extends TransformerAbstract
{
    public function transform(UserModel $user)
    {
        return [
            'id'                         => (int) $user->id,
            'enabled'                    => (int) $user->enabled,
            'archived'                   => (int) $user->archived,
            'locale'                     => $user->locale,
            'localeEnabled'              => (int) $user->localeEnabled,
            'slug'                       => $user->slug,
            'uri'                        => $user->uri,
            'dateCreated'                => $user->dateCreated,
            'dateUpdated'                => $user->dateUpdated,
            'root'                       => $user->root,
            'lft'                        => (int) $user->lft,
            'rgt'                        => (int) $user->rgt,
            'level'                      => (int) $user->level,
            'username'                   => $user->username,
            'firstName'                  => $user->firstName,
            'lastName'                   => $user->lastName,
            'email'                      => $user->email,
            'password'                   => $user->password,
            'preferredLocale'            => $user->preferredLocale,
            'weekStartDay'               => $user->weekStartDay,
            'admin'                      => (int) $user->admin,
            'client'                     => (int) $user->client,
            'locked'                     => (int) $user->locked,
            'suspended'                  => (int) $user->suspended,
            'pending'                    => (int) $user->pending,
            'lastLoginDate'              => $user->lastLoginDate,
            'invalidLoginCount'          => $user->invalidLoginCount ? (int) $user->invalidLoginCount : $user->invalidLoginCount,
            'lastInvalidLoginDate'       => $user->lastInvalidLoginDate,
            'lockoutDate'                => $user->lockoutDate,
            'passwordResetRequired'      => $user->passwordResetRequired,
            'lastPasswordChangeDate'     => $user->lastPasswordChangeDate,
            'unverifiedEmail'            => $user->unverifiedEmail,
            'newPassword'                => $user->newPassword,
            'currentPassword'            => $user->currentPassword,
            'verificationCodeIssuedDate' => $user->verificationCodeIssuedDate,
        ];
    }
}
