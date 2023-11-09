<?php

declare(strict_types=1);

namespace CornerMonkey\ConditionalAssertions\Tests;

use CornerMonkey\ConditionalAssertions\Tests\Fixture\DummyConditionalAssertionTrait;
use CornerMonkey\ConditionalAssertions\WhenProxy;
use PHPUnit\Framework\TestCase;

use RuntimeException;

final class ConditionalAssertionTraitTest extends TestCase
{
    private const UPDATED = 'updated';
    private DummyConditionalAssertionTrait $classForTrait;

    protected function setUp(): void
    {
        $this->classForTrait = new DummyConditionalAssertionTrait();
    }

    public function testWhenOnlyValue(): void
    {
        $this->assertInstanceOf(WhenProxy::class, $this->classForTrait->when(true));
    }

    public function testWhenWithValueAndCallbackAndValueIsTrue(): void
    {
        $updatable = null;
        $this->assertSame(
            $this->classForTrait,
            $this->classForTrait->when(true, function ($class, $value) use (&$updatable): void {
                self::assertTrue($value);
                self::assertSame($this->classForTrait, $class);

                $updatable = self::UPDATED;
            }),
        );

        $this->assertSame(self::UPDATED, $updatable);
    }

    public function testWhenWithValueAndCallbackAndValueIsFalse(): void
    {
        $this->assertSame(
            $this->classForTrait,
            $this->classForTrait->when(false, static function ($class, $value): void {
                throw new RuntimeException('This should not be called');
            }),
        );
    }

    public function testUnlessOnlyValue(): void
    {
        $this->assertInstanceOf(WhenProxy::class, $this->classForTrait->unless(true));
    }

    public function testUnlessValueAndCallbackAndValueIsTrue(): void
    {
        $this->assertSame(
            $this->classForTrait,
            $this->classForTrait->unless(true, static function ($class, $value): void {
                throw new RuntimeException('This should not be called');
            }),
        );
    }

    public function testUnlessValueAndCallbackAndValueIsFalse(): void
    {
        $updatable = null;
        $this->assertSame(
            $this->classForTrait,
            $this->classForTrait->unless(false, function ($class, $value) use (&$updatable): void {
                self::assertFalse($value);
                self::assertSame($this->classForTrait, $class);

                $updatable = self::UPDATED;
            }),
        );

        $this->assertSame(self::UPDATED, $updatable);
    }
}
