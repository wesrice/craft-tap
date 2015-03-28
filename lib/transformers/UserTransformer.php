<?php
namespace Tap\Transformers;

use League\Fractal\TransformerAbstract;
use Craft\UserModel;
use Craft\Craft;

class UserTransformer extends TransformerAbstract
{
    public function transform(UserModel $element)
    {
        return [
            'id'                         => (int) $element->id,
            'enabled'                    => (int) $element->enabled,
            'archived'                   => (int) $element->archived,
            'locale'                     => $element->locale,
            'localeEnabled'              => (int) $element->localeEnabled,
            'slug'                       => $element->slug,
            'uri'                        => $element->uri,
            'dateCreated'                => $element->dateCreated,
            'dateUpdated'                => $element->dateUpdated,
            'root'                       => $element->root,
            'lft'                        => (int) $element->lft,
            'rgt'                        => (int) $element->rgt,
            'level'                      => (int) $element->level,
            'username'                   => $element->username,
            'firstName'                  => $element->firstName,
            'lastName'                   => $element->lastName,
            'email'                      => $element->email,
            'password'                   => $element->password,
            'preferredLocale'            => $element->preferredLocale,
            'weekStartDay'               => $element->weekStartDay,
            'admin'                      => (int) $element->admin,
            'client'                     => (int) $element->client,
            'locked'                     => (int) $element->locked,
            'suspended'                  => (int) $element->suspended,
            'pending'                    => (int) $element->pending,
            'lastLoginDate'              => $element->lastLoginDate,
            'invalidLoginCount'          => $element->invalidLoginCount ? (int) $element->invalidLoginCount : $element->invalidLoginCount,
            'lastInvalidLoginDate'       => $element->lastInvalidLoginDate,
            'lockoutDate'                => $element->lockoutDate,
            'passwordResetRequired'      => $element->passwordResetRequired,
            'lastPasswordChangeDate'     => $element->lastPasswordChangeDate,
            'unverifiedEmail'            => $element->unverifiedEmail,
            'newPassword'                => $element->newPassword,
            'currentPassword'            => $element->currentPassword,
            'verificationCodeIssuedDate' => $element->verificationCodeIssuedDate,
        ];
    }
}
