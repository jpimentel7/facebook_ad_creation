<?php
/**
 * Created by PhpStorm.
 * User: javi
 * Date: 3/23/19
 * Time: 12:30 PM
 */

class FacebookSettings
{
    public function getAppSecret()
    {
        return '';
    }

    public function getAppId()
    {
        return '';
    }

    public function getUserToken()
    {
        return '';
    }

    public function getFacebookDateFormat()
    {
        // YYYY-MM-DD
        return 'Y-m-d';
    }

    public function getPageId(){
        return '';
    }

    public function getDefaultAdAccount()
    {
        return 'act_<ad account id>';
    }
}