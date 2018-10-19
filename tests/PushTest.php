<?php

declare(strict_types=1);

namespace Wearesho\Notifications\MessageDelivery\Tests;

use Wearesho\Notifications;
use Wearesho\Delivery;
use PHPUnit\Framework\TestCase;

/**
 * Class PushTest
 * @package Wearesho\Notifications\MessageDelivery\Tests
 */
class PushTest extends TestCase
{
    public function testNoRecipint(): void
    {
        $repository = new class implements Notifications\MessageDelivery\RecipientRepositoryInterface
        {
            public function find(int $id): ?string
            {
                return null;
            }
        };
        $service = new Delivery\ServiceMock();

        $push = new Notifications\MessageDelivery\Push($service, $repository);

        $push->push(new Notifications\Notification(1, 'Hello World!'));
        $this->assertCount(0, $service->getRepository()->getHistory());
    }

    public function testSent(): void
    {
        $repository = new class implements Notifications\MessageDelivery\RecipientRepositoryInterface
        {
            public function find(int $id): ?string
            {
                return 'recipient';
            }
        };
        $service = new Delivery\ServiceMock();

        $push = new Notifications\MessageDelivery\Push($service, $repository);

        $push->push(new Notifications\Notification(1, 'Hello {name}!', ['name' => 'World']));

        /** @var Delivery\MessageInterface[] $history */
        $history = $service->getRepository()->getHistory();
        $this->assertCount(1, $history);

        $message = $history[0];

        $this->assertEquals('Hello World!', $message->getText());
        $this->assertEquals('recipient', $message->getRecipient());
    }
}
