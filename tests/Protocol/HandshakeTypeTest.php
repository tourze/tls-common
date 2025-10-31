<?php

namespace Tourze\TLSCommon\Tests\Protocol;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use Tourze\TLSCommon\Protocol\HandshakeType;

/**
 * @internal
 */
#[CoversClass(HandshakeType::class)]
final class HandshakeTypeTest extends AbstractEnumTestCase
{
    public function testHandshakeTypeConstants(): void
    {
        $this->assertSame(1, HandshakeType::CLIENT_HELLO->value);
        $this->assertSame(2, HandshakeType::SERVER_HELLO->value);
        $this->assertSame(11, HandshakeType::CERTIFICATE->value);
        $this->assertSame(12, HandshakeType::SERVER_KEY_EXCHANGE->value);
        $this->assertSame(13, HandshakeType::CERTIFICATE_REQUEST->value);
        $this->assertSame(14, HandshakeType::SERVER_HELLO_DONE->value);
        $this->assertSame(15, HandshakeType::CERTIFICATE_VERIFY->value);
        $this->assertSame(16, HandshakeType::CLIENT_KEY_EXCHANGE->value);
        $this->assertSame(20, HandshakeType::FINISHED->value);
    }

    public function testAsString(): void
    {
        $this->assertSame('ClientHello', HandshakeType::CLIENT_HELLO->asString());
        $this->assertSame('ServerHello', HandshakeType::SERVER_HELLO->asString());
        $this->assertSame('Certificate', HandshakeType::CERTIFICATE->asString());
        $this->assertSame('ServerKeyExchange', HandshakeType::SERVER_KEY_EXCHANGE->asString());
        $this->assertSame('CertificateRequest', HandshakeType::CERTIFICATE_REQUEST->asString());
        $this->assertSame('ServerHelloDone', HandshakeType::SERVER_HELLO_DONE->asString());
        $this->assertSame('CertificateVerify', HandshakeType::CERTIFICATE_VERIFY->asString());
        $this->assertSame('ClientKeyExchange', HandshakeType::CLIENT_KEY_EXCHANGE->asString());
        $this->assertSame('Finished', HandshakeType::FINISHED->asString());
    }

    public function testFromIntWithValidValues(): void
    {
        $this->assertSame(HandshakeType::CLIENT_HELLO, HandshakeType::fromInt(1));
        $this->assertSame(HandshakeType::SERVER_HELLO, HandshakeType::fromInt(2));
        $this->assertSame(HandshakeType::CERTIFICATE, HandshakeType::fromInt(11));
        $this->assertSame(HandshakeType::SERVER_KEY_EXCHANGE, HandshakeType::fromInt(12));
        $this->assertSame(HandshakeType::CERTIFICATE_REQUEST, HandshakeType::fromInt(13));
        $this->assertSame(HandshakeType::SERVER_HELLO_DONE, HandshakeType::fromInt(14));
        $this->assertSame(HandshakeType::CERTIFICATE_VERIFY, HandshakeType::fromInt(15));
        $this->assertSame(HandshakeType::CLIENT_KEY_EXCHANGE, HandshakeType::fromInt(16));
        $this->assertSame(HandshakeType::FINISHED, HandshakeType::fromInt(20));
    }

    public function testFromIntWithInvalidValues(): void
    {
        $this->assertNull(HandshakeType::fromInt(0));
        $this->assertNull(HandshakeType::fromInt(100));
        $this->assertNull(HandshakeType::fromInt(-1));
    }

    public function testToStringWithValidValues(): void
    {
        $this->assertSame('ClientHello', HandshakeType::toString(1));
        $this->assertSame('ServerHello', HandshakeType::toString(2));
        $this->assertSame('Certificate', HandshakeType::toString(11));
        $this->assertSame('ServerKeyExchange', HandshakeType::toString(12));
        $this->assertSame('CertificateRequest', HandshakeType::toString(13));
        $this->assertSame('ServerHelloDone', HandshakeType::toString(14));
        $this->assertSame('CertificateVerify', HandshakeType::toString(15));
        $this->assertSame('ClientKeyExchange', HandshakeType::toString(16));
        $this->assertSame('Finished', HandshakeType::toString(20));
    }

    public function testToStringWithInvalidValues(): void
    {
        $this->assertSame('未知握手类型(0x00)', HandshakeType::toString(0));
        $this->assertSame('未知握手类型(0x64)', HandshakeType::toString(100));
        $this->assertSame('未知握手类型(0xFF)', HandshakeType::toString(255));
    }

    public function testToArray(): void
    {
        $result = HandshakeType::CLIENT_HELLO->toArray();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('label', $result);

        $this->assertSame(1, $result['value']);
        $this->assertSame('客户端Hello', $result['label']);

        // 测试另一个枚举值
        $result2 = HandshakeType::SERVER_HELLO->toArray();
        $this->assertSame(2, $result2['value']);
        $this->assertSame('服务器Hello', $result2['label']);
    }
}
