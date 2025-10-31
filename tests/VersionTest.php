<?php

namespace Tourze\TLSCommon\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use Tourze\TLSCommon\Protocol\TLSVersion;

/**
 * @internal
 */
#[CoversClass(TLSVersion::class)]
final class VersionTest extends AbstractEnumTestCase
{
    public function testVersionConstants(): void
    {
        $this->assertSame(0x0300, TLSVersion::SSL_3_0->value);
        $this->assertSame(0x0301, TLSVersion::TLS_1_0->value);
        $this->assertSame(0x0302, TLSVersion::TLS_1_1->value);
        $this->assertSame(0x0303, TLSVersion::TLS_1_2->value);
        $this->assertSame(0x0304, TLSVersion::TLS_1_3->value);
    }

    public function testAsString(): void
    {
        $this->assertSame('SSL 3.0', TLSVersion::SSL_3_0->asString());
        $this->assertSame('TLS 1.0', TLSVersion::TLS_1_0->asString());
        $this->assertSame('TLS 1.1', TLSVersion::TLS_1_1->asString());
        $this->assertSame('TLS 1.2', TLSVersion::TLS_1_2->asString());
        $this->assertSame('TLS 1.3', TLSVersion::TLS_1_3->asString());
    }

    public function testFromIntWithValidValues(): void
    {
        $this->assertSame(TLSVersion::SSL_3_0, TLSVersion::fromInt(0x0300));
        $this->assertSame(TLSVersion::TLS_1_0, TLSVersion::fromInt(0x0301));
        $this->assertSame(TLSVersion::TLS_1_1, TLSVersion::fromInt(0x0302));
        $this->assertSame(TLSVersion::TLS_1_2, TLSVersion::fromInt(0x0303));
        $this->assertSame(TLSVersion::TLS_1_3, TLSVersion::fromInt(0x0304));
    }

    public function testFromIntWithInvalidValue(): void
    {
        $this->assertNull(TLSVersion::fromInt(0x0000));
        $this->assertNull(TLSVersion::fromInt(0x0305));
        $this->assertNull(TLSVersion::fromInt(-1));
    }

    public function testIsSupportedForSupportedVersions(): void
    {
        $this->assertTrue(TLSVersion::TLS_1_0->isSupported());
        $this->assertTrue(TLSVersion::TLS_1_1->isSupported());
        $this->assertTrue(TLSVersion::TLS_1_2->isSupported());
        $this->assertTrue(TLSVersion::TLS_1_3->isSupported());
    }

    public function testIsSupportedForUnsupportedVersions(): void
    {
        $this->assertFalse(TLSVersion::SSL_3_0->isSupported());
    }

    public function testToStringWithValidValues(): void
    {
        $this->assertSame('SSL 3.0', TLSVersion::toString(0x0300));
        $this->assertSame('TLS 1.0', TLSVersion::toString(0x0301));
        $this->assertSame('TLS 1.1', TLSVersion::toString(0x0302));
        $this->assertSame('TLS 1.2', TLSVersion::toString(0x0303));
        $this->assertSame('TLS 1.3', TLSVersion::toString(0x0304));
    }

    public function testToStringWithInvalidValue(): void
    {
        $this->assertSame('未知版本(0x0000)', TLSVersion::toString(0x0000));
        $this->assertSame('未知版本(0x0305)', TLSVersion::toString(0x0305));
        $this->assertSame('未知版本(0xFFFF)', TLSVersion::toString(0xFFFF));
    }

    public function testIsSupportedVersionWithValidValues(): void
    {
        $this->assertFalse(TLSVersion::isSupportedVersion(0x0300));
        $this->assertTrue(TLSVersion::isSupportedVersion(0x0301));
        $this->assertTrue(TLSVersion::isSupportedVersion(0x0302));
        $this->assertTrue(TLSVersion::isSupportedVersion(0x0303));
        $this->assertTrue(TLSVersion::isSupportedVersion(0x0304));
    }

    public function testIsSupportedVersionWithInvalidValues(): void
    {
        $this->assertFalse(TLSVersion::isSupportedVersion(0x0000));
        $this->assertFalse(TLSVersion::isSupportedVersion(0x0305));
        $this->assertFalse(TLSVersion::isSupportedVersion(-1));
    }

    public function testToArray(): void
    {
        $result = TLSVersion::TLS_1_2->toArray();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('label', $result);

        $this->assertSame(0x0303, $result['value']);
        $this->assertSame('TLS 1.2', $result['label']);

        // 测试另一个枚举值
        $result2 = TLSVersion::TLS_1_3->toArray();
        $this->assertSame(0x0304, $result2['value']);
        $this->assertSame('TLS 1.3 (推荐)', $result2['label']);
    }
}
