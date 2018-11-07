<?php

declare(strict_types=1);

namespace Wearesho\Notifications\MessageDelivery;

use Wearesho\Notifications;
use Wearesho\Delivery;
use mef\Stringifier\Stringifier;
use mef\StringInterpolation;

/**
 * Class Push
 * @package Wearesho\Notifications\MessageDelivery
 */
class Push implements Notifications\Push
{
    /** @var Delivery\ServiceInterface */
    protected $service;

    /** @var RecipientRepositoryInterface */
    protected $repository;

    /** @var StringInterpolation\StringInterpolatorInterface */
    protected $interpolator;

    public function __construct(
        Delivery\ServiceInterface $service,
        RecipientRepositoryInterface $repository,
        StringInterpolation\StringInterpolatorInterface $interpolator = null
    ) {
        $this->service = $service;
        $this->repository = $repository;
        $this->interpolator = $interpolator ?? new StringInterpolation\PlaceholderInterpolator(
            new Stringifier
        );
    }

    /**
     * @param Notifications\Notification $notification
     * @throws Delivery\Exception
     */
    public function push(Notifications\Notification $notification): void
    {
        $user = $notification->getUser();
        $recipient = $this->repository->find($user);

        if (is_null($recipient)) {
            return;
        }

        $message = $notification->getMessage();
        $context = $notification->getContext() ?? [];

        $text = $this->interpolator->getInterpolatedString($message, $context);

        $this->service->send(new Delivery\Message($text, $recipient));
    }
}
