<?php
namespace app\models;

use yii\base\Model;
use yii\web\IdentityInterface;

/**
 * Simple User (Guest) model
 */
class GuestUser extends Model implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }
}
