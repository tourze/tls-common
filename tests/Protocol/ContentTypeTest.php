<?php

namespace Tourze\TLSCommon\Tests\Protocol;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use Tourze\TLSCommon\Protocol\ContentType;

/**
 * @internal
 */
#[CoversClass(ContentType::class)]
final class ContentTypeTest extends AbstractEnumTestCase
{
    public function testContentTypeConstants(): void
    {
        $this->assertSame(20, ContentType::CHANGE_CIPHER_SPEC->value);
        $this->assertSame(21, ContentType::ALERT->value);
        $this->assertSame(22, ContentType::HANDSHAKE->value);
        $this->assertSame(23, ContentType::APPLICATION_DATA->value);
        $this->assertSame(24, ContentType::HEARTBEAT->value);

        // 测试常量值
        $this->assertSame(23, ContentType::TLS13_APPLICATION_DATA);
    }

    public function testAsString(): void
    {
        $this->assertSame('ChangeCipherSpec', ContentType::CHANGE_CIPHER_SPEC->asString());
        $this->assertSame('Alert', ContentType::ALERT->asString());
        $this->assertSame('Handshake', ContentType::HANDSHAKE->asString());
        $this->assertSame('ApplicationData', ContentType::APPLICATION_DATA->asString());
        $this->assertSame('Heartbeat', ContentType::HEARTBEAT->asString());
    }

    public function testFromIntWithValidValues(): void
    {
        $this->assertSame(ContentType::CHANGE_CIPHER_SPEC, ContentType::fromInt(20));
        $this->assertSame(ContentType::ALERT, ContentType::fromInt(21));
        $this->assertSame(ContentType::HANDSHAKE, ContentType::fromInt(22));
        $this->assertSame(ContentType::APPLICATION_DATA, ContentType::fromInt(23));
        $this->assertSame(ContentType::HEARTBEAT, ContentType::fromInt(24));
    }

    public function testFromIntWithInvalidValues(): void
    {
        $this->assertNull(ContentType::fromInt(0));
        $this->assertNull(ContentType::fromInt(19));
        $this->assertNull(ContentType::fromInt(25));
        $this->assertNull(ContentType::fromInt(-1));
    }

    public function testToStringWithValidValues(): void
    {
        $this->assertSame('ChangeCipherSpec', ContentType::toString(20));
        $this->assertSame('Alert', ContentType::toString(21));
        $this->assertSame('Handshake', ContentType::toString(22));
        $this->assertSame('ApplicationData', ContentType::toString(23));
        $this->assertSame('Heartbeat', ContentType::toString(24));
    }

    public function testToStringWithInvalidValues(): void
    {
        $this->assertSame('未知内容类型(0x00)', ContentType::toString(0));
        $this->assertSame('未知内容类型(0x13)', ContentType::toString(19));
        $this->assertSame('未知内容类型(0x19)', ContentType::toString(25));
        $this->assertSame('未知内容类型(0xFF)', ContentType::toString(255));
    }

    public function testToArray(): void
    {
        $result = ContentType::ALERT->toArray();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('label', $result);

        $this->assertSame(21, $result['value']);
        $this->assertSame('警告', $result['label']);

        // 测试另一个枚举值
        $result2 = ContentType::HANDSHAKE->toArray();
        $this->assertSame(22, $result2['value']);
        $this->assertSame('握手', $result2['label']);
    }
}
