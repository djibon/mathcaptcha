#Captcha

> A simple captcha for laravel 4 

## Preview

![Preview](http://aparnet.ir/wp-content/uploads/2014/04/captcha.png)

##How to setup

update `composer.json` file:

```json
{
    "require": {
        "laravel/framework": "4.1.*",
        "devfactory/captcha": "dev-master"
    }
}
```

and run `composer update` from terminal to download files.

update `app.php` file in `app/config` directory:

```php
'providers' => array(
  devfactory\Captcha\CaptchaServiceProvider'
),
```

```php
alias => array(
      'Captcha' => 'devfactory\Captcha\Facades\Captcha'
),
```

##How to use

in your HTML form add following code:

```html
{{ Captcha::img('captcha1') }}
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

