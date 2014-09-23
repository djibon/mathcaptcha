#Captcha

> A simple Math Captcha for laravel 4 

this work based on laravel captcha https://bitbucket.org/devfactory/captcha/
##How to setup

update `composer.json` file:

```json
{
    "require": {
        "laravel/framework": "4.1.*",
        "djibon/captcha": "dev-master"
    }
}
```

and run `composer update` from terminal to download files.

update `app.php` file in `app/config` directory:

```php
'providers' => array(
  Djibon\Captcha\CaptchaServiceProvider'
),
```

```php
alias => array(
      'Captcha' => 'Djibon\Captcha\Facades\Captcha'
),
```

##How to use

in your HTML form add following code:

```html
{{ Captcha::img_math('captcha1') }}
{{ Form::text('input_captcha') }}

```

and for validate user entered data just add `captcha` to array validation rules.

```php
$rules = array(
  'input_captcha' => 'required|captcha:captcha1'
);

$validator = Validator::make(Input::all(), $rules);

if($validator -> fails()) {
  return Redirect::back() -> withErrors($validator);
}
```

