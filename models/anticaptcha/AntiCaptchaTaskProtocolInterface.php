<?php
namespace app\models\anticaptcha;


interface AntiCaptchaTaskProtocolInterface
{
    public function getPostData();

    public function setTaskInfo($taskInfo);

    public function getTaskSolution();
}