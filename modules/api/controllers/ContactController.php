<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Contact controller for the `api` module
 */
class ContactController extends ActiveController
{
    public $modelClass = \app\models\Contact::class;
}
