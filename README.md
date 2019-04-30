# Gockets
[**Gockets**]((https://github.com/gockets-project/gockets#gockets)) is daemon written in Golang to give languages, like PHP a middleware for REST-oriented communication with Websockets.

# Gockets PHP

This library provides implemented and ready to use interface for gockets daemon.


# Installation via Composer

`composer require gockets/gockets-php`

## Quickstart

#### Setup Gockets server

[Gockets page](https://github.com/gockets-project/gockets)

#### Setup PHP client

```php
use Gockets\Client;
use Gockets\Model\Params;

$host = 'localhost'; // Default value
$port = '8844'; // Default value

$client = new Client(new Params($host, $port));
```

#### Prepare channel

Creates new channel.

```php
// Using variable from previous example

$channel = $client->prepare();
```

`Gockets\Model\Сhannel` example:

```php
object(Gockets\Model\Channel) {
  ["publisherToken":private] => string(32) "f177965656399535ea241a3da40dfcbf"
  ["subscriberToken":private] => string(32) "90b09a2e2d43c83ed907854a46c710fd"
  ["hookUrl":private] => NULL
  ["listeners":private] => int(0)
}
```

#### Show channel

Returns specific channel.

```php
$publisherToken = '95e9aca9575c29ca8cdc92e54767d783';

$channel = $client->show($publisherToken);
```

#### Show all channels

Returns empty or filled with `Gockets\Model\Сhannel` objects array.

```php
$channels = $client->showAll();
```

#### Publish data

Send some data to channel.
In this example `$channel` variable contains `Gockets\Model\Сhannel` object.

```php
$data = [
    'data' => 'content',
];

$response = $client->publish($data, $channel->getPublisherToken());
```

`Gockets\Model\Response $response` example:

```php
object(Gockets\Model\Response) {
  ["success":private] => bool(true)
  ["type":private] => string(3) "INF"
  ["message":private] => string(38) "Successfully pushed data to subscriber"
}
```

Always try to ensure that `$success` property of response is `true`.

#### Close channel

Closes connection and removes channel.

```php
$response = $client->close($channel->getPublisherToken());

echo $response->getMessage(); // Outputs "Successfully closed connection"
```

#### Error handling

Mostly error handling currently in development, but in case if publisher token was not found library throws `Gockets\Exception\ChannelNotFoundException`.

```php
use Gockets\Exception\ChannelNotFoundException;

try {
    $client->show('some-publisher-token');
} catch (ChannelNotFoundException $exception) {
    // Your logic when publisher token was not found
}
```

In `bin` directory located Gockets builded instance for Linux. For more information about Golang project refer to [it's](https://github.com/gockets-project/gockets#gockets) page.
