# Tochka API v2 client for PHP

PHP SDK для Точка банк API версия 2

[Устаревшая первая версия API](https://github.com/lee-to/php-tochka-api-sdk)

## Installation

Tochka API client for PHP can be installed with [Composer](https://getcomposer.org/). Run this command:

```sh
composer require lee-to/php-tochka-api-v2-sdk
```

## Использование

[Документация](https://enter.tochka.com/doc/v2/redoc#section/Pro-API)

### Импорт.
```php
use TochkaApi\Client;
use TochkaApi\HttpAdapters\CurlHttpClient;
```

### Инициализация.
- Создаем приложение в личном кабинете Точка банк в разделе "Интеграции" и прописываем доступы
```php
$tochkaApi = new \TochkaApi\Client("client_id", "client_secret", "redirect_uri", new CurlHttpClient);
```

### OAuth2 авторизация.
- Подтверждаем права пользования для приложения. Метод вернет урл для прохождения авторизации
- Согласно документации code живет 2 минуты

```php
// Урл для авторизации, после подтверждения вернет $_GET["code"] на redirect_uri
$authorizeUrl = $tochkaApi->authorize();
header("Location: {$authorizeUrl}");
exit( );

//После успешной авторизации и подтверждения прав Точка банк выполнит редирект на redirect_uri указанный в Вашем приложении
//c параметром code
// code обменяется на токен и установится в клиент
$accessToken = $client->token($_GET["code"]);
$tochkaApi->setAccessToken($accessToken);
//Access token живет 24 часа
//Refresh token живет 30 дней

//Проверка не устарел ли токен ($createdTimestamp - timestamp создания токена)
if($tochkaApi->isExpired($createdTimestamp)) {

}
```

### Обновления токена

```php
//Вернет объект AccessToken
$client->refreshToken(string $refresh_token);
```

### Разрешения
- https://enter.tochka.com/doc/v2/redoc#section/Authentication
- По умолчанию установлены все разрешения

```php
//Изменить scopes
$tochkaApi->setScopes(string $scopes);
```

```php
//Изменить permissions
$tochkaApi->setPermissions(array $permissions);
```

### Работа со счетами
#### Метод получения списка доступных счетов
- https://enter.tochka.com/doc/v2/redoc#operation/get_accounts_list_open_banking__apiVersion__accounts_get

``` php
$tochkaApi->account()->all()
```

#### Метод получения информации по конкретному счёту
- https://enter.tochka.com/doc/v2/redoc#operation/get_account_info_open_banking__apiVersion__accounts__accountId__get

Параметры:

* $accountId - Уникальный и неизменный идентификатор счёта

``` php
$tochkaApi->account($accountId)->get()
```

#### Метод получения информации о балансе конкретного счета
- https://enter.tochka.com/doc/v2/redoc#operation/get_balance_info_open_banking__apiVersion__accounts__accountId__balances_get

Параметры:

* $accountID - Идентификатор счета

``` php
$tochkaApi->account($accountID)->balances()
```

#### Метод получения конкретной выписки
- https://enter.tochka.com/doc/v2/redoc#operation/get_statement_open_banking__apiVersion__accounts__accountId__statements__statementId__get

Параметры:

* $accountID - Идентификатор счета
* $statementId - Идентификатор выписки

``` php
$tochkaApi->account($accountID)->statement($statementId)
```

### Работа с балансами счетов
#### Метод получения баланса по нескольким счетам
- https://enter.tochka.com/doc/v2/redoc#operation/get_balances_list_open_banking__apiVersion__balances_get
``` php
$tochkaApi->balance()->all()
```

### Работа с выписками

#### Метод получения списка доступных выписок
- https://enter.tochka.com/doc/v2/redoc#operation/get_statements_list_open_banking__apiVersion__statements_get
``` php
$tochkaApi->statement()->all()
```

#### Метод создания выписки по конкретному счету
- https://enter.tochka.com/doc/v2/redoc#operation/init_statement_open_banking__apiVersion__statements_post

Параметры:

* $data - Request Body согласно документации

``` php
$tochkaApi->statement()->create($data)
```


### Работа с картами

#### Метод получения списка карт

- https://enter.tochka.com/doc/v2/redoc#operation/get_cards_card__api_version__card_get

Параметры:

* $cardCode - GUID карты в ПЦ Точки
* $customerCode - Уникальный код клиента

``` php
$tochkaApi->card($cardCode, $customerCode)->all()
```

#### Метод редактирования карты

- https://enter.tochka.com/doc/v2/redoc#operation/edit_card_card__apiVersion__card__cardCode__post

Параметры:

* $cardCode - GUID карты в ПЦ Точки
* $customerCode - Уникальный код клиента
* $data - Request Body согласно документации

``` php
$tochkaApi->card($cardCode, $customerCode)->update($data)
```

#### Метод закрытия карты

- https://enter.tochka.com/doc/v2/redoc#operation/delete_card_card__apiVersion__card__cardCode__delete

Параметры:

* $cardCode - GUID карты в ПЦ Точки
* $customerCode - Уникальный код клиента

``` php
$tochkaApi->card($cardCode, $customerCode)->delete()
```

#### Показывает действующие лимиты по карте

- https://enter.tochka.com/doc/v2/redoc#operation/get_card_limits_card__apiVersion__card__cardCode__limits_get

Параметры:

* $cardCode - GUID карты в ПЦ Точки
* $customerCode - Уникальный код клиента
* $query - Query parameters согласно документации

``` php
$tochkaApi->card($cardCode, $customerCode)->limits($query)
```

#### Метод смены состояния карты

- https://enter.tochka.com/doc/v2/redoc#operation/edit_card_state_card__apiVersion__card__cardCode__state_post

Параметры:

* $cardCode - GUID карты в ПЦ Точки
* $customerCode - Уникальный код клиента
* $data - Request Body согласно документации

``` php
$tochkaApi->card($cardCode, $customerCode)->state($data)
```

### Работа с клиентами
#### Метод получения списка доступных клиентов
- https://enter.tochka.com/doc/v2/redoc#operation/get_customers_list_open_banking__apiVersion__customers_get
``` php
$tochkaApi->customer()->all()
```

#### Метод получения информации по конкретному клиенту
- https://enter.tochka.com/doc/v2/redoc#operation/get_customer_info_open_banking__apiVersion__customers__customerCode__get

Параметры:

* $customerCode - Уникальный код клиента

``` php
$tochkaApi->customer($customerCode)->get()
```

### Работа с платежами
#### Методы создания и подписания платежа
- https://enter.tochka.com/doc/v2/redoc#section/Opisanie-metodov/Rabota-s-platezhami
- https://enter.tochka.com/doc/v2/redoc#operation/create_payment_for_sign_payment__apiVersion__for_sign_post
- https://enter.tochka.com/doc/v2/redoc#operation/create_payment_payment__apiVersion__order_post

Параметры:

* $data - Request Body согласно документации
* $forSign - С подписью либо без

``` php
$tochkaApi->payment()->create($data, $forSign = true)
```

- Метод создания и подписания платежа ($forSign = false) вернет ответ вида

``` json
    "Data": {
    "requestId": "openapi-b96d770e-769f-49ce-9630-890e00d47720",
    "redirectURL": "https://enter.tochka.com/payment/?requestId=openapi-b96d770e-769f-49ce-9630-890e00d47720&clientId=ВАШ_КЛИЕНТ_ID"
}
```

* где redirectURL - Ссылка на страницу для редиректа. В query-параметрах указываются поля платежа. Далее необходимо подписать платеж кодом

#### Метод получения статуса платежа
- https://enter.tochka.com/doc/v2/redoc#operation/get_payment_status_payment__apiVersion__status__requestId__get

Параметры:

* $requestId - Идентификатор запроса (платежа)

``` php
$tochkaApi->payment($requestId)->get()
```

### Выполнение произвольного запроса к API (Пока методы СБП в разработке)

Параметры:

* $method - GET|POST|DELETE|UPDATE|PUT
* $url - Урл, например https://enter.tochka.com/uapi/sbp/v1.0/merchant/MF0000000001
* $data - Request Body

``` php
$tochkaApi->custom()->request($method, $url, $data = [])
```

* Если требуется customer-code в header

``` php
$tochkaApi->custom(null, $customerCode)->request($method, $url, $data = [])
```

## Tests

1. [Composer](https://getcomposer.org/) is a prerequisite for running the tests. Install composer globally, then run `composer install` to install required files.
2. The tests can be executed by running this command from the root directory:

```bash
./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Danil Shutsky](https://github.com/lee-to)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Security

If you have found a security issue, please contact the maintainers directly at [leetodev@ya.ru](mailto:leetodev@ya.ru).