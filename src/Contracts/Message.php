<?php

namespace Viloveul\Validation\Contracts;

use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;

interface Message extends ArrayAccess, JsonSerializable, IteratorAggregate
{
    public function getCode(): int;

    public function getDetail(): string;

    public function getTitle(): string;

    public function toArray(): array;
}
