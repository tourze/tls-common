<?php

namespace Tourze\TLSCommon\Tests\Protocol;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use Tourze\TLSCommon\Protocol\TLSVersion;

/**
 * @internal
 */
#[CoversClass(TLSVersion::class)]
final class TLSVersionTest extends AbstractEnumTestCase
{
    /**
     * 测试版本值
     */
    public function testVersionValues(): void
    {
        $this->assertEquals(0x0300, TLSVersion::SSL_3_0->value);
        $this->assertEquals(0x0301, TLSVersion::TLS_1_0->value);
        $this->assertEquals(0x0302, TLSVersion::TLS_1_1->value);
        $this->assertEquals(0x0303, TLSVersion::TLS_1_2->value);
        $this->assertEquals(0x0304, TLSVersion::TLS_1_3->value);
    }

    /**
     * 测试获取版本名称
     */
    public function testGetName(): void
    {
        $this->assertEquals('SSL 3.0', TLSVersion::SSL_3_0->getName());
        $this->assertEquals('TLS 1.0', TLSVersion::TLS_1_0->getName());
        $this->assertEquals('TLS 1.1', TLSVersion::TLS_1_1->getName());
        $this->assertEquals('TLS 1.2', TLSVersion::TLS_1_2->getName());
        $this->assertEquals('TLS 1.3', TLSVersion::TLS_1_3->getName());
    }

    /**
     * 测试判断版本是否安全
     */
    public function testIsSecure(): void
    {
        $this->assertFalse(TLSVersion::SSL_3_0->isSecure());
        $this->assertFalse(TLSVersion::TLS_1_0->isSecure());
        $this->assertFalse(TLSVersion::TLS_1_1->isSecure());
        $this->assertTrue(TLSVersion::TLS_1_2->isSecure());
        $this->assertTrue(TLSVersion::TLS_1_3->isSecure());
    }

    /**
     * 测试获取版本名称（静态方法）
     */
    public function testGetVersionName(): void
    {
        $this->assertEquals('TLS 1.2', TLSVersion::getVersionName(0x0303));
        $this->assertEquals('Unknown (0x0305)', TLSVersion::getVersionName(0x0305));
    }

    /**
     * 测试获取推荐的版本列表
     */
    public function testGetRecommendedVersions(): void
    {
        $versions = TLSVersion::getRecommendedVersions();

        $this->assertCount(2, $versions);
        $this->assertEquals(TLSVersion::TLS_1_3, $versions[0]);
        $this->assertEquals(TLSVersion::TLS_1_2, $versions[1]);
    }

    /**
     * 测试获取字符串表示
     */
    public function testAsString(): void
    {
        $this->assertSame('SSL 3.0', TLSVersion::SSL_3_0->asString());
        $this->assertSame('TLS 1.0', TLSVersion::TLS_1_0->asString());
        $this->assertSame('TLS 1.1', TLSVersion::TLS_1_1->asString());
        $this->assertSame('TLS 1.2', TLSVersion::TLS_1_2->asString());
        $this->assertSame('TLS 1.3', TLSVersion::TLS_1_3->asString());
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
