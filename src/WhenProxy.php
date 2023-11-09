<?php

declare(strict_types=1);

namespace CornerMonkey\ConditionalAssertions;

/**
 * A proxy class that allows for conditional assertion.
 *
 * @template-covariant TProxy
 *
 * @mixin TProxy
 */
final class WhenProxy
{
    /**
     * The condition for proxying.
     */
    private bool $condition = false;

    /**
     * Create a new proxy instance.
     *
     * @param TProxy $target
     */
    public function __construct(protected mixed $target) {}

    /**
     * Proxy a method call on the target when the condition is not false.
     *
     * @param array<mixed> $parameters
     *
     * @return TProxy
     */
    public function __call(string $method, array $parameters)
    {
        if ($this->condition) {
            $this->target->{$method}(...$parameters);
        }

        return $this->target;
    }

    /**
     * Set the condition on the proxy.
     *
     * @return self<TProxy>
     */
    public function condition(bool $condition): self
    {
        $this->condition = $condition;

        return $this;
    }
}
