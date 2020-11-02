<?php
namespace Misc\Model\Entity;

use Cake\ORM\Entity;

class BaseEntity extends Entity
{
    /**
     * @var array
     */
    protected $_accessible = [
        '*' => false,
    ];
}
