<?php

namespace app\modules\api\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

/**
 * Contact controller for the `api` module
 */
class ContactController extends ActiveController
{
    public $modelClass = \app\models\Contact::class;

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//
//        $behaviors['authenticator']['class'] = HttpBasicAuth::class;
//
//        $behaviors['authenticator']['auth'] = function ($username, $password) {
//            $user = User::findOne([
//                'username' => $username,
//            ]);
//
//            if (!$user) {
//                return null;
//            }
//
//            return $user->validatePassword($password) ? $user : null;
//        };
//
//        return $behaviors;
//    }
}
