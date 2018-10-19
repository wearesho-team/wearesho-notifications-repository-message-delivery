<?php

namespace Wearesho\Notifications\MessageDelivery;

/**
 * Interface RecipientRepositoryInterface
 * @package Wearesho\Notifications\MessageDelivery
 */
interface RecipientRepositoryInterface
{
    public function find(int $id): ?string;
}
