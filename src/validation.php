<?php

Validator::extend('captcha', function($attribute, $value, $parameters)
{
    return Captcha::validate($value, $parameters);
});