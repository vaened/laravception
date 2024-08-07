# Laravception

Laravception standardizes error responses in Laravel, ensuring all exceptions have a unique code, clear message, and metadata. It supports error message translation, promotes specific exception classes, and adapts details based on the environment.

![Carbon source code](https://github.com/user-attachments/assets/35a5c171-316b-478b-879c-0324961d38ef)

## Instalation
Laravception requires PHP 8.2.
To get the latest version, simply require the project using Composer:

```bash
composer require vaened/laravception
```

Now. Publish the configuration file.

```bash
php artisan vendor:publish --provider='Vaened\Laravception\LaravceptionServiceProvider'
```

## Usage
Laravception captures exceptions thrown by the application and standardizes their structure. The unified structure is as follows:
```json
{
  "code": "Exception error code",
  "message": "Exception message",
  "params": {
    "Exception parameters" 
  },
  "meta": [
    "metadata that the exception might export"
  ],
  "exception": "Exception name",
  "file": "File where exception was thrown",
  "line": "Line that threw the exception",
  "trace": [
    "Full stack trace of the exception"
  ]
}
```
`This structure will hide certain details based on whether the environment is set to development or production.`

### Translations
To enable exception translation, implement the interface [TranslatableException](./src/Exceptions/TranslatableException.php). This is sufficient to start translating child exceptions.

```php
final class InvalidCreditCardException extends RuntimeException implements TranslatableException
{  
  // this is enough
}
```

It’s recommended to create a custom exception class for each error to allow more specific translations. For example, with the exception **_“InvalidCreditCardException”_**, you can have a translation entry in the **exceptions** file:**exceptions**:
```php 
[
  "invalid_credit_card_exception" => "La tarjeta de credito ingresada no es válida".
]
```

This functionality is enabled by default. Any exceptions that do not implement [Codeable](./src/Exceptions/Codeable.php) will be treated in the same manner, converting the class name to snake_case and using this transformation as the error code and key for the translation.

For better error code management, you can implement [Codeable](./src/Exceptions/Codeable.php). In the exception **_“InvalidCreditCardException”_**, you can return a custom error code such as **payments.invalid_credit_card**, and in your translation file:
```php 
[
  "payments" => [
    "invalid_credit_card" => "La tarjeta de crédito ingresada no es válida".
  ]
]
```
You can also add parameters by implementing the [Parametrizable](./src/Exceptions/Parametrizable.php) interface. Return an array with the properties to be used, and your translation file will look like this:

```php 
[
  "payments" => [
    "invalid_credit_card" => "La tarjeta de crédito <:card_number> no es válida".
  ]
]
```

We can finally have this implementation:
```php
final class InvalidCreditCardException extends RuntimeException 
	implements TranslatableException, Codeable, Parametrizable  
{  
    public function __construct(private readonly string $cardNumber)  
    {  
        parent::__construct("The credit card number <$cardNumber> is invalid");  
    }  
  
    public function errorCode(): string  
    {  
        return 'payments.invalid_credit_card';  
    }  
  
    public function parameters(): array  
    {  
        return [  
            'card_number' => $this->personId,  
        ];  
    }  
}
```

## Configuration

To understand the various configuration options, please refer to the comments in the configuration file [laravception.php](./config/laravception.php).

## Principles

The core idea behind this library is to standardize error messages in a Laravel project, ensuring that all exceptions follow a common structure.

## Specific Exceptions

To improve API organization and documentation, it is recommended to create custom exceptions with a specific purpose, such as ***"PaymentFailedException"*** or ***"ClientNotFoundException"*** This allows for more precise and effective handling of exceptions.

## Translation of Messages

With specific exceptions, presenting error messages can be automated using unique codes. This makes it easier to translate and decorate error messages, ensuring they are clear and useful for both developers and end-users.

## License
This library is licensed under the MIT License. For more information, please see the [`license`](./license) file.