<?php

namespace Tourze\TLSCommon\Tests\Protocol;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use Tourze\TLSCommon\Protocol\AlertLevel;

/**
 * @internal
 */
#[CoversClass(AlertLevel::class)]
final class AlertLevelTest extends AbstractEnumTestCase
{
    public function testAlertLevelConstants(): void
    {
        $this->assertSame(1, AlertLevel::WARNING->value);
        $this->assertSame(2, AlertLevel::FATAL->value);
    }

    public function testAsString(): void
    {
        $this->assertSame('警告', AlertLevel::WARNING->asString());
        $this->assertSame('致命', AlertLevel::FATAL->asString());
    }

    public function testFromIntWithValidValues(): void
    {
        $this->assertSame(AlertLevel::WARNING, AlertLevel::fromInt(1));
        $this->assertSame(AlertLevel::FATAL, AlertLevel::fromInt(2));
    }

    public function testFromIntWithInvalidValues(): void
    {
        $this->assertNull(AlertLevel::fromInt(0));
        $this->assertNull(AlertLevel::fromInt(3));
        $this->assertNull(AlertLevel::fromInt(-1));
    }

    public function testToStringWithValidValues(): void
    {
        $this->assertSame('警告', AlertLevel::toString(1));
        $this->assertSame('致命', AlertLevel::toString(2));
    }

    public function testToStringWithInvalidValues(): void
    {
        $this->assertSame('未知警告级别(0x00)', AlertLevel::toString(0));
        $this->assertSame('未知警告级别(0x03)', AlertLevel::toString(3));
        $this->assertSame('未知警告级别(0xFF)', AlertLevel::toString(255));
    }

    public function testToArray(): void
    {
        $result = AlertLevel::WARNING->toArray();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('label', $result);

        $this->assertSame(1, $result['value']);
        $this->assertSame('警告', $result['label']);

        // 测试另一个枚举值
        $result2 = AlertLevel::FATAL->toArray();
        $this->assertSame(2, $result2['value']);
        $this->assertSame('致命', $result2['label']);
    }
}
