<?php

declare(strict_types=1);

namespace CornerMonkey\ConditionalAssertions\Tests;

use CornerMonkey\ConditionalAssertions\Tests\Fixture\DummyInterface;
use CornerMonkey\ConditionalAssertions\WhenProxy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class WhenProxyTest extends TestCase
{
    /** @var WhenProxy<DummyInterface> */
    private WhenProxy $proxy;

    /** @var (DummyInterface&MockObject)|DummyInterface|MockObject */
    private DummyInterface|MockObject $mockClass;

    protected function setUp(): void
    {
        $this->mockClass = $this->createMock(DummyInterface::class);
        $this->proxy = new WhenProxy($this->mockClass);
    }

    public function testProxyClassMethodIsCalledWhenConditionIsTrue(): void
    {
        $this->mockClass
            ->expects($this->once())
            ->method('dummyMethod');

        $this->proxy
            ->condition(true)
            ->dummyMethod('test');
    }

    public function testProxyClassMethodIsNotCalledWhenConditionIsFalse(): void
    {
        $this->mockClass
            ->expects($this->never())
            ->method('dummyMethod');

        $this->proxy
            ->condition(false)
            ->dummyMethod();
    }

    public function testProxyClassMethodIsNotCalledWhenConditionIsNotSet(): void
    {
        $this->mockClass
            ->expects($this->never())
            ->method('dummyMethod');

        $this->proxy
            ->dummyMethod();
    }
}
