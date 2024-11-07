<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    /**
     * 使用者ID
     *
     * @var integer
     */
    protected $u_id;

    /**
     * 購買人名
     *
     * @var string
     */
    protected $first_name;

    /**
     * 購買人姓
     *
     * @var string
     */
    protected $last_name;

    /**
     * email
     *
     * @var string
     */
    protected $email;

    /**
     * 密碼
     *
     * @var string
     */
    protected $password;

    /**
     * 手機號碼
     *
     * @var string
     */
    protected $cellphone_number;

    /**
     * 建立時間
     *
     * @var string
     */
    protected $createdAt;

    /**
     * 最後更新時間
     *
     * @var string
     */
    protected $updatedAt;

    /**
     * 刪除時間
     *
     * @var string
     */
    protected $deletedAt;

    protected $datamap = [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
        'deletedAt' => 'deleted_at'
    ];

    protected $casts = [
        'u_id' => 'integer'
    ];

    protected $dates = [];
}
