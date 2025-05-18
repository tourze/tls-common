<?php

namespace Tourze\TLSCommon\Tests\Protocol;

use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Protocol\AlertLevel;

final class AlertLevelTest extends TestCase
{
    public function testAlertLevelConstants()
    {
        $this->assertSame(1, AlertLevel::WARNING->value);
        $this->assertSame(2, AlertLevel::FATAL->value);
    }

    public function testAsString()
    {
        $this->assertSame('警告', AlertLevel::WARNING->asString());
        $this->assertSame('致命', AlertLevel::FATAL->asString());
    }

    public function testFromInt_withValidValues()
    {
        $this->assertSame(AlertLevel::WARNING, AlertLevel::fromInt(1));
        $this->assertSame(AlertLevel::FATAL, AlertLevel::fromInt(2));
    }

    public function testFromInt_withInvalidValues()
    {
        $this->assertNull(AlertLevel::fromInt(0));
        $this->assertNull(AlertLevel::fromInt(3));
        $this->assertNull(AlertLevel::fromInt(-1));
    }

    public function testToString_withValidValues()
    {
        $this->assertSame('警告', AlertLevel::toString(1));
        $this->assertSame('致命', AlertLevel::toString(2));
    }

    public function testToString_withInvalidValues()
    {
        $this->assertSame('未知警告级别(0x00)', AlertLevel::toString(0));
        $this->assertSame('未知警告级别(0x03)', AlertLevel::toString(3));
        $this->assertSame('未知警告级别(0xFF)', AlertLevel::toString(255));
    }
}
