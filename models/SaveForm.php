<?php


namespace app\models;

use Yii;
use yii\base\Model;

class SaveForm
{
    public $iin;
    public $accountKey;

    public function rules()
    {
        return [
            [['iin'], 'required']
        ];
    }

}