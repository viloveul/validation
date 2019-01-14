<?php

namespace Viloveul\Validation;

use ArrayIterator;
use Viloveul\Validation\Contracts\Message as IMessage;

class Message implements IMessage
{
    /**
     * @var mixed
     */
    protected $code;

    /**
     * @var mixed
     */
    protected $detail;

    /**
     * @var array
     */
    protected $maps = [
        'code' => 'getCode',
        'title' => 'getTitle',
        'detail' => 'getDetail',
    ];

    /**
     * @var mixed
     */
    protected $title;

    /**
     * @param $title
     * @param $detail
     * @param $code
     */
    public function __construct($title, $detail, $code = 400)
    {
        $this->code = $code;
        $this->title = $title;
        $this->detail = $detail;
    }

    /**
     * @return mixed
     */
    public function getCode(): int
    {
        return abs($this->code);
    }

    /**
     * @return mixed
     */
    public function getDetail(): string
    {
        return (string) $this->detail;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * @return mixed
     */
    public function getTitle(): string
    {
        return ucwords((string) $this->title);
    }

    /**
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param $key
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->maps);
    }

    /**
     * @param $key
     */
    public function offsetGet($key)
    {
        return array_key_exists($key, $this->maps) ? call_user_func([$this, $this->maps[$key]]) : null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function offsetSet($key, $value)
    {
        if (array_key_exists($key, $this->maps)) {
            $this->{$key} = $value;
        }
    }

    /**
     * @param $key
     */
    public function offsetUnset($key)
    {
        if (array_key_exists($key, $this->maps)) {
            $this->{$key} = null;
        }
    }

    /**
     * @return mixed
     */
    public function toArray(): array
    {
        return array_map(function ($value) {
            return $this->{$value}();
        }, $this->maps);
    }
}
