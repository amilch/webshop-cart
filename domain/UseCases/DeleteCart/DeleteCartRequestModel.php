<?php

namespace Domain\UseCases\DeleteCart;

class DeleteCartRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {}

    public function getSessionId(): string
    {
        return $this->attributes['session_id'];
    }
}
