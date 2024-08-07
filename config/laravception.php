<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

use Vaened\Laravception\Exceptions\TranslatableException;

return [
    /*
    |--------------------------------------------------------------------------
    | Exception Decoding Mode
    |--------------------------------------------------------------------------
    |
    | Specify the default mode that will be used to decode exceptions. This
    | value should correspond to a decoder defined in the 'decoders' array.
    | The default mode is 'snake_case', which converts exception class names
    | to a readable snake_case format. This mode is only used if the exception
    | does not implement the Codeable interface. If the Codeable interface is
    | implemented, the exception codes will be taken from that implementation.
    |
    */
    'decode'       => 'snake_case',

    /*
    |--------------------------------------------------------------------------
    | Exception Decoders
    |--------------------------------------------------------------------------
    |
    | This array lists the available decoders for transforming exception class
    | names into different formats. Each decoder is represented by a class that
    | implements the decoding logic. These decoders are used only if the
    | exception does not implement the Codeable interface.
    |
    */
    'decoders'     => [
        // The 'snake_case' decoder converts exception class names to snake_case format.
        'snake_case' => Vaened\Laravception\Decoders\SnakeCaseExceptionNameParser::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Exception Translations
    |--------------------------------------------------------------------------
    |
    | Specify the translation repositories for exceptions. Each key in this
    | array corresponds to an exception class, and the value is the name of the
    | translation file where the translations for that exception will be found.
    | The order in this array matters: more specific exceptions should be
    | listed before more general ones (like Throwable) to ensure that
    | specific translations are applied first.
    |
    */
    'translations' => [
        // Translations for exceptions implementing TranslatableException will be
        // found in the 'exceptions' translation file.
        TranslatableException::class => 'exceptions',
    ],

    /*
    |--------------------------------------------------------------------------
    | Exception Handlers
    |--------------------------------------------------------------------------
    |
    | This array lists the exception handlers that the library will use. Each handler
    | is represented by a class that implements the logic for handling specific types
    | of exceptions. The order in this array matters: more specific handlers should
    | be listed before more general ones to ensure that specific handling is applied
    | first. For example, if a handler targets Throwable and is listed first, it will
    | catch all exceptions and prevent more specific handlers from being invoked.
    |
    */
    'handlers'     => [
        Vaened\Laravception\Handlers\ValidationExceptionHandler::class,
        Vaened\Laravception\Handlers\ThrowableHandler::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Exception Status Code Mapping
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify the class responsible for mapping
    | exceptions to HTTP status codes. The default class provided handles
    | common exception types, but you can customize it to suit your needs.
    |
    */
    'code_mapper'  => Vaened\Laravception\HttpExceptionStatusCodeMapping::class,
];
