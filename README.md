# Eggdigital/Auth

Auth for generete API key (use for authentication).

Eggdigital/Auth is a small library that helps you generate key

Installation

1. after you download package you need to put this line for tell your server to know package

'EggDigital\Auth\ServiceServiceProvider',

Note: put this line in providers (app.php)

2. Call method to generate API key.

## Example

In this package you can simply generate api key by call method genCdnApiKey
like this 

CDNApiKey::genCdnApiKey($service_id, $private_key);

you need to pass service id and private key to method