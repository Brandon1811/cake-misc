<?php
namespace Misc\Model\Table;

use ArrayObject;
use Misc\Model\Entity\PasswordResetAttempt;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PasswordResetAttempts Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\PasswordResetAttempt get($primaryKey, $options = [])
 * @method \App\Model\Entity\PasswordResetAttempt newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PasswordResetAttempt[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PasswordResetAttempt|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PasswordResetAttempt saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PasswordResetAttempt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PasswordResetAttempt[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PasswordResetAttempt findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PasswordResetAttemptsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('password_reset_attempts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 15)
            ->requirePresence('ip', 'create')
            ->notEmptyString('ip');

        $validator
            ->integer('ip_long')
            ->requirePresence('ip_long', 'create')
            ->notEmptyString('ip_long');

        $validator
            ->dateTime('expires')
            ->allowEmptyDateTime('expires');

        $validator
            ->dateTime('reset_at')
            ->allowEmptyDateTime('reset_at');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->requirePresence('token', 'create')
            ->notEmptyString('token');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     *  Before Marshal Event
     *
     * @param \Cake\Event\Event $event The event object
     * @param ArrayObject $data entity data to be marshaled
     * @param ArrayObject $options save options
     *
     * @return void
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {

    }

    /**
     *  Before Save Event
     *
     * @param \Cake\Event\Event $event The event object
     * @param PasswordResetAttempt $PasswordResetAttempt entity to be saved
     * @param ArrayObject $options save options
     *
     * @return bool|void
     */
    public function beforeSave(Event $event, PasswordResetAttempt $PasswordResetAttempt, ArrayObject $options)
    {

    }

    /**
     *  After Save Event
     *
     * @param \Cake\Event\Event $event The event object
     * @param PasswordResetAttempt $entity entity that was saved
     * @param ArrayObject $options save options
     *
     * @return bool|void
     */
    public function afterSave(Event $event, PasswordResetAttempt $PasswordResetAttempt, ArrayObject $options)
    {

    }
}
