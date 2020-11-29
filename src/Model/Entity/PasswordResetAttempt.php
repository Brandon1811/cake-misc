<?php
namespace Misc\Model\Entity;

use Misc\Model\Entity\BaseEntity;

/**
 * PasswordResetAttempt Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property int $ip_long
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $expires
 * @property \Cake\I18n\FrozenTime|null $reset_at
 * @property string $token
 *
 * @property \App\Model\Entity\User $user
 */
class PasswordResetAttempt extends BaseEntity
{    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
