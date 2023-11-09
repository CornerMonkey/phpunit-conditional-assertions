<?php

declare(strict_types=1);

namespace CornerMonkey\ConditionalAssertions\Tests\Fixture;

interface DummyInterface
{
    public function dummyMethod(string $random = null): void;
}
