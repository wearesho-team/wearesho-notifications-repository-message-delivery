# Wearesho Notification Repository Message Delivery
[![Build Status](https://travis-ci.org/wearesho-team/wearesho-notifications-repository-message-delivery.svg?branch=master)](https://travis-ci.org/wearesho-team/wearesho-notifications-repository-message-delivery)
[![codecov](https://codecov.io/gh/wearesho-team/wearesho-notifications-repository-message-delivery/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/wearesho-notifications-repository-message-delivery)

This package allows you to use [Message Delivery](https://github.com/wearesho-team/message-delivery)
as proxy [Push](https://github.com/wearesho-team/wearesho-notifications-repository/blob/1.1.0/src/Push.php)
for [Wearesho Notifications Repository](https://github.com/wearesho-team/wearesho-notifications-repository).

## Installation

```bash
composer require wearesho-team/wearesho-notifications-repository-message-delivery
```

## Usage

First, you need to implement [RecipientRepositoryInterface](./src/RecipientRepositoryInterface.php)
to convert user id from notification into message delivery recipient *(example: phone)*

```php
<?php

use Wearesho\Notifications\MessageDelivery;
use Wearesho\Delivery;

/** @var Delivery\ServiceInterface $service */
/** @var MessageDelivery\RecipientRepositoryInterface $repository */

$push = new MessageDelivery\Push($service, $repository);

// use Push in NotificationRepository chain, for example

```

## License
[MIT](./LICENSE)
