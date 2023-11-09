<?php

declare(strict_types=1);

namespace CornerMonkey\ConditionalAssertions;

use Closure;

use function func_num_args;

/**
 * A trait that allows for conditional assertion.
 */
trait ConditionalAssertionTrait
{
    /**
     * @param Closure|mixed                      $value
     * @param null|callable(static, mixed): void $callback
     *
     * @return static|WhenProxy<static>
     */
    public function when(mixed $value, callable $callback = null): static|WhenProxy
    {
        $value = $value instanceof Closure ? $value($this) : $value;

        if (func_num_args() === 1) {
            return (new WhenProxy($this))->condition($value);
        }

        if ($value && $callback !== null) {
            $callback($this, $value);
        }

        return $this;
    }

    /**
     * @param Closure|mixed                      $value
     * @param null|callable(static, mixed): void $callback
     *
     * @return static|WhenProxy<static>
     */
    public function unless(mixed $value, callable $callback = null): static|WhenProxy
    {
        $value = $value instanceof Closure ? $value($this) : $value;

        if (func_num_args() === 1) {
            return (new WhenProxy($this))->condition(!$value);
        }

        if (!$value && $callback !== null) {
            $callback($this, $value);
        }

        return $this;
    }
}
