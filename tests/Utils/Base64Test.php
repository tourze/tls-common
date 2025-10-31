<?php

namespace Tourze\TLSCommon\Tests\Utils;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Exception\InvalidArgumentException;
use Tourze\TLSCommon\Utils\Base64;

/**
 * @internal
 */
#[CoversClass(Base64::class)]
final class Base64Test extends TestCase
{
    public function testEncodeWithStandardBase64(): void
    {
        $this->assertSame('', Base64::encode(''));
        $this->assertSame('aGVsbG8=', Base64::encode('hello'));
        $this->assertSame('aGVsbG8gd29ybGQ=', Base64::encode('hello world'));
        $this->assertSame('AAD/AA==', Base64::encode("\x00\x00\xff\x00"));
    }

    public function testEncodeWithUrlSafeBase64(): void
    {
        $this->assertSame('', Base64::encode('', true));
        $this->assertSame('aGVsbG8', Base64::encode('hello', true));
        $this->assertSame('aGVsbG8gd29ybGQ', Base64::encode('hello world', true));
        $this->assertSame('AAD_AA', Base64::encode("\x00\x00\xff\x00", true));
    }

    public function testDecodeWithStandardBase64(): void
    {
        $this->assertSame('', Base64::decode(''));
        $this->assertSame('hello', Base64::decode('aGVsbG8='));
        $this->assertSame('hello world', Base64::decode('aGVsbG8gd29ybGQ='));
        $this->assertSame("\x00\x00\xff\x00", Base64::decode('AAD/AA=='));
    }

    public function testDecodeWithWhitespace(): void
    {
        $this->assertSame('hello', Base64::decode(" aGVs\nbG8= "));
    }

    public function testDecodeWithUrlSafeBase64(): void
    {
        $this->assertSame('', Base64::decode('', true));
        $this->assertSame('hello', Base64::decode('aGVsbG8', true));
        $this->assertSame('hello world', Base64::decode('aGVsbG8gd29ybGQ', true));
        $this->assertSame("\x00\x00\xff\x00", Base64::decode('AAD_AA', true));
    }

    public function testDecodeWithInvalidBase64(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('输入不是有效的Base64字符串');
        Base64::decode('not base64!');
    }

    public function testToPEMWithCertificate(): void
    {
        $data = 'certificate data';
        $pem = Base64::toPEM($data, 'CERTIFICATE');

        $this->assertStringStartsWith("-----BEGIN CERTIFICATE-----\n", $pem);
        $this->assertStringContainsString('Y2VydGlmaWNhdGUgZGF0YQ', $pem);
        $this->assertStringEndsWith("-----END CERTIFICATE-----\n", $pem);
    }

    public function testToPEMWithPrivateKey(): void
    {
        $data = 'private key data';
        $pem = Base64::toPEM($data, 'PRIVATE KEY');

        $this->assertStringStartsWith("-----BEGIN PRIVATE KEY-----\n", $pem);
        $this->assertStringContainsString('cHJpdmF0ZSBrZXkgZGF0YQ', $pem);
        $this->assertStringEndsWith("-----END PRIVATE KEY-----\n", $pem);
    }

    public function testToPEMWithLongData(): void
    {
        $data = str_repeat('a', 100);
        $pem = Base64::toPEM($data, 'TEST');

        $this->assertStringStartsWith("-----BEGIN TEST-----\n", $pem);
        // 我们不检查具体的Base64编码，因为不同平台的行尾可能不同
        $this->assertStringContainsString('YWFh', $pem);  // 'aaa' 的base64开头
        $this->assertStringEndsWith("-----END TEST-----\n", $pem);

        // 确认解码后内容正确
        $extracted = Base64::fromPEM($pem);
        $this->assertSame($data, $extracted);
    }

    public function testFromPEMWithCertificate(): void
    {
        $pem = "-----BEGIN CERTIFICATE-----\n" .
               "Y2VydGlmaWNhdGUgZGF0YQ==\n" .
               "-----END CERTIFICATE-----\n";
        $this->assertSame('certificate data', Base64::fromPEM($pem));
    }

    public function testFromPEMWithPrivateKey(): void
    {
        $pem = "-----BEGIN PRIVATE KEY-----\n" .
               "cHJpdmF0ZSBrZXkgZGF0YQ==\n" .
               "-----END PRIVATE KEY-----\n";
        $this->assertSame('private key data', Base64::fromPEM($pem));
    }

    public function testFromPEMWithWhitespace(): void
    {
        $pem = " \n -----BEGIN TEST----- \n Y2VydGlmaWNhdGUgZGF0YQ== \n -----END TEST----- \n ";
        $this->assertSame('certificate data', Base64::fromPEM($pem));
    }

    public function testFromPEMWithMultilineData(): void
    {
        $pem = "-----BEGIN TEST-----\n" .
               "AAAABBBBCCCC\n" .
               "DDDDEEEEFFFF\n" .
               "-----END TEST-----\n";
        $this->assertSame(base64_decode('AAAABBBBCCCCDDDDEEEEFFFF', true), Base64::fromPEM($pem));
    }

    public function testFromPEMWithInvalidFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('输入不是有效的PEM格式');
        Base64::fromPEM('not a PEM format');
    }

    public function testFromPEMWithInvalidBase64Data(): void
    {
        $pem = "-----BEGIN TEST-----\n" .
               "not a valid base64!\n" .
               "-----END TEST-----\n";

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('PEM格式中的Base64数据无效');
        Base64::fromPEM($pem);
    }
}
