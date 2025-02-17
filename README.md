# Laravel DKIM

[![Donate](https://img.shields.io/badge/Donate-PayPal-blue.svg)](https://www.paypal.me/simonschaufi/20)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/simonschaufi?label=GitHub%20Sponsors)](https://github.com/sponsors/simonschaufi)
[![Buy me a coffee](https://img.shields.io/badge/-Buy_me_a_coffee-gray?logo=buymeacoffee)](https://www.buymeacoffee.com/simonschaufi)
![GitHub](https://img.shields.io/github/license/simonschaufi/laravel-dkim)
[![Packagist Downloads](https://img.shields.io/packagist/dt/simonschaufi/laravel-dkim)](https://packagist.org/packages/simonschaufi/laravel-dkim)
[![Laravel 9/10/11/12](https://img.shields.io/badge/Laravel-9/10/11/12-ff2d20)](https://laravel.com)

A Laravel package, that allows signing emails with DKIM.

## Installation

```bash
composer require simonschaufi/laravel-dkim
```

In **Laravel version before 11**, the providers array in `config/app.php` has an entry with `Illuminate\Mail\MailServiceProvider::class`. Comment this 
line out and add your own service provider entry (in the "Package Service Providers" section):

```php
/*
 * Package Service Providers...
 */
SimonSchaufi\LaravelDKIM\DKIMMailServiceProvider::class,
```

In **Laravel 11/12**, add this to your `bootstrap/app.php`:
```php
->withProviders([
    \SimonSchaufi\LaravelDKIM\DKIMMailServiceProvider::class,
])
```

The DKIMMailServiceProvider extends the MailServiceProvider and overwrites a method that we need for our own behavior.

After that, you should publish the config file with:

```bash
php artisan vendor:publish --provider="SimonSchaufi\LaravelDKIM\DKIMMailServiceProvider" --tag dkim-config
```

Next we need to create a private and public key pair for signing and verifying the email.

There are many tools available to generate the necessary keys but here is one which is easy to use:

https://tools.socketlabs.com/dkim/generator

Enter your domain and in the "selector" field enter `default`, or adjust the "selector" in the laravel config file accordingly. Leave the remaining fields as they are.

After you have generated the keys and added the public key to your dns record, here is a tool to validate it:

https://www.mail-tester.com/spf-dkim-check

Finally, store the private key for example in `storage/app/dkim/private_key.txt` and configure your settings in `.env`:

```ini
DKIM_DOMAIN=example.com
```

If you placed the private key somewhere else, you need to set the **full absolute path** in the environment variable 
or adjust the storage path in the config file.

**If you find this package helpful, please consider a donation!** Links are on top of this file.
