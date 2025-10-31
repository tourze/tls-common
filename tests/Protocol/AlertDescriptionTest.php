<?php

namespace Tourze\TLSCommon\Tests\Protocol;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use Tourze\TLSCommon\Protocol\AlertDescription;

/**
 * @internal
 */
#[CoversClass(AlertDescription::class)]
final class AlertDescriptionTest extends AbstractEnumTestCase
{
    public function testAlertDescriptionConstants(): void
    {
        $this->assertSame(0, AlertDescription::CLOSE_NOTIFY->value);
        $this->assertSame(10, AlertDescription::UNEXPECTED_MESSAGE->value);
        $this->assertSame(20, AlertDescription::BAD_RECORD_MAC->value);
        $this->assertSame(21, AlertDescription::DECRYPTION_FAILED->value);
        $this->assertSame(22, AlertDescription::RECORD_OVERFLOW->value);
        $this->assertSame(30, AlertDescription::DECOMPRESSION_FAILURE->value);
        $this->assertSame(40, AlertDescription::HANDSHAKE_FAILURE->value);
        $this->assertSame(41, AlertDescription::NO_CERTIFICATE->value);
        $this->assertSame(42, AlertDescription::BAD_CERTIFICATE->value);
        $this->assertSame(43, AlertDescription::UNSUPPORTED_CERTIFICATE->value);
        $this->assertSame(44, AlertDescription::CERTIFICATE_REVOKED->value);
        $this->assertSame(45, AlertDescription::CERTIFICATE_EXPIRED->value);
        $this->assertSame(46, AlertDescription::CERTIFICATE_UNKNOWN->value);
        $this->assertSame(47, AlertDescription::ILLEGAL_PARAMETER->value);
        $this->assertSame(48, AlertDescription::UNKNOWN_CA->value);
        $this->assertSame(49, AlertDescription::ACCESS_DENIED->value);
        $this->assertSame(50, AlertDescription::DECODE_ERROR->value);
        $this->assertSame(51, AlertDescription::DECRYPT_ERROR->value);
        $this->assertSame(70, AlertDescription::PROTOCOL_VERSION->value);
        $this->assertSame(71, AlertDescription::INSUFFICIENT_SECURITY->value);
        $this->assertSame(80, AlertDescription::INTERNAL_ERROR->value);
        $this->assertSame(86, AlertDescription::INAPPROPRIATE_FALLBACK->value);
        $this->assertSame(90, AlertDescription::USER_CANCELED->value);
        $this->assertSame(109, AlertDescription::MISSING_EXTENSION->value);
        $this->assertSame(110, AlertDescription::UNSUPPORTED_EXTENSION->value);
        $this->assertSame(111, AlertDescription::CERTIFICATE_UNOBTAINABLE->value);
        $this->assertSame(112, AlertDescription::UNRECOGNIZED_NAME->value);
        $this->assertSame(113, AlertDescription::BAD_CERTIFICATE_STATUS_RESPONSE->value);
        $this->assertSame(114, AlertDescription::BAD_CERTIFICATE_HASH_VALUE->value);
        $this->assertSame(115, AlertDescription::UNKNOWN_PSK_IDENTITY->value);
        $this->assertSame(116, AlertDescription::CERTIFICATE_REQUIRED->value);
        $this->assertSame(120, AlertDescription::NO_APPLICATION_PROTOCOL->value);
    }

    public function testAsString(): void
    {
        $this->assertSame('close_notify', AlertDescription::CLOSE_NOTIFY->asString());
        $this->assertSame('unexpected_message', AlertDescription::UNEXPECTED_MESSAGE->asString());
        $this->assertSame('bad_record_mac', AlertDescription::BAD_RECORD_MAC->asString());
        $this->assertSame('decryption_failed', AlertDescription::DECRYPTION_FAILED->asString());
        $this->assertSame('record_overflow', AlertDescription::RECORD_OVERFLOW->asString());
        $this->assertSame('decompression_failure', AlertDescription::DECOMPRESSION_FAILURE->asString());
        $this->assertSame('handshake_failure', AlertDescription::HANDSHAKE_FAILURE->asString());
    }

    public function testFromIntWithValidValues(): void
    {
        $this->assertSame(AlertDescription::CLOSE_NOTIFY, AlertDescription::fromInt(0));
        $this->assertSame(AlertDescription::UNEXPECTED_MESSAGE, AlertDescription::fromInt(10));
        $this->assertSame(AlertDescription::BAD_RECORD_MAC, AlertDescription::fromInt(20));
        $this->assertSame(AlertDescription::HANDSHAKE_FAILURE, AlertDescription::fromInt(40));
        $this->assertSame(AlertDescription::INTERNAL_ERROR, AlertDescription::fromInt(80));
        $this->assertSame(AlertDescription::NO_APPLICATION_PROTOCOL, AlertDescription::fromInt(120));
    }

    public function testFromIntWithInvalidValues(): void
    {
        $this->assertNull(AlertDescription::fromInt(1));
        $this->assertNull(AlertDescription::fromInt(200));
        $this->assertNull(AlertDescription::fromInt(-1));
    }

    public function testToStringWithValidValues(): void
    {
        $this->assertSame('close_notify', AlertDescription::toString(0));
        $this->assertSame('unexpected_message', AlertDescription::toString(10));
        $this->assertSame('bad_record_mac', AlertDescription::toString(20));
        $this->assertSame('handshake_failure', AlertDescription::toString(40));
        $this->assertSame('internal_error', AlertDescription::toString(80));
        $this->assertSame('no_application_protocol', AlertDescription::toString(120));
    }

    public function testToStringWithInvalidValues(): void
    {
        $this->assertSame('未知警告描述(0x01)', AlertDescription::toString(1));
        $this->assertSame('未知警告描述(0xC8)', AlertDescription::toString(200));
        $this->assertSame('未知警告描述(0xFF)', AlertDescription::toString(255));
    }

    public function testToArray(): void
    {
        $result = AlertDescription::CLOSE_NOTIFY->toArray();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('value', $result);
        $this->assertArrayHasKey('label', $result);

        $this->assertSame(0, $result['value']);
        $this->assertSame('关闭通知', $result['label']);

        // 测试另一个枚举值
        $result2 = AlertDescription::UNEXPECTED_MESSAGE->toArray();
        $this->assertSame(10, $result2['value']);
        $this->assertSame('意外消息', $result2['label']);
    }
}
