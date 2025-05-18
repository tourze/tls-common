<?php

namespace Tourze\TLSCommon\Tests\Utils;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Utils\Base64;

final class Base64Test extends TestCase
{
    public function testEncode_withStandardBase64()
    {
        $this->assertSame('', Base64::encode(''));
        $this->assertSame('aGVsbG8=', Base64::encode('hello'));
        $this->assertSame('aGVsbG8gd29ybGQ=', Base64::encode('hello world'));
        $this->assertSame('AAD/AA==', Base64::encode("\x00\x00\xff\x00"));
    }

    public function testEncode_withUrlSafeBase64()
    {
        $this->assertSame('', Base64::encode('', true));
        $this->assertSame('aGVsbG8', Base64::encode('hello', true));
        $this->assertSame('aGVsbG8gd29ybGQ', Base64::encode('hello world', true));
        $this->assertSame('AAD_AA', Base64::encode("\x00\x00\xff\x00", true));
    }

    public function testDecode_withStandardBase64()
    {
        $this->assertSame('', Base64::decode(''));
        $this->assertSame('hello', Base64::decode('aGVsbG8='));
        $this->assertSame('hello world', Base64::decode('aGVsbG8gd29ybGQ='));
        $this->assertSame("\x00\x00\xff\x00", Base64::decode('AAD/AA=='));
    }

    public function testDecode_withWhitespace()
    {
        $this->assertSame('hello', Base64::decode(" aGVs\nbG8= "));
    }

    public function testDecode_withUrlSafeBase64()
    {
        $this->assertSame('', Base64::decode('', true));
        $this->assertSame('hello', Base64::decode('aGVsbG8', true));
        $this->assertSame('hello world', Base64::decode('aGVsbG8gd29ybGQ', true));
        $this->assertSame("\x00\x00\xff\x00", Base64::decode('AAD_AA', true));
    }

    public function testDecode_withInvalidBase64()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('输入不是有效的Base64字符串');
        Base64::decode('not base64!');
    }

    public function testToPEM_withCertificate()
    {
        $data = 'certificate data';
        $pem = Base64::toPEM($data, 'CERTIFICATE');
        
        $this->assertStringStartsWith("-----BEGIN CERTIFICATE-----\n", $pem);
        $this->assertStringContainsString("Y2VydGlmaWNhdGUgZGF0YQ", $pem);
        $this->assertStringEndsWith("-----END CERTIFICATE-----\n", $pem);
    }

    public function testToPEM_withPrivateKey()
    {
        $data = 'private key data';
        $pem = Base64::toPEM($data, 'PRIVATE KEY');
        
        $this->assertStringStartsWith("-----BEGIN PRIVATE KEY-----\n", $pem);
        $this->assertStringContainsString("cHJpdmF0ZSBrZXkgZGF0YQ", $pem);
        $this->assertStringEndsWith("-----END PRIVATE KEY-----\n", $pem);
    }

    public function testToPEM_withLongData()
    {
        $data = str_repeat('a', 100);
        $pem = Base64::toPEM($data, 'TEST');
        
        $this->assertStringStartsWith("-----BEGIN TEST-----\n", $pem);
        // 我们不检查具体的Base64编码，因为不同平台的行尾可能不同
        $this->assertStringContainsString("YWFh", $pem);  // 'aaa' 的base64开头
        $this->assertStringEndsWith("-----END TEST-----\n", $pem);
        
        // 确认解码后内容正确
        $extracted = Base64::fromPEM($pem);
        $this->assertSame($data, $extracted);
    }

    public function testFromPEM_withCertificate()
    {
        $pem = "-----BEGIN CERTIFICATE-----\n" .
               "Y2VydGlmaWNhdGUgZGF0YQ==\n" .
               "-----END CERTIFICATE-----\n";
        $this->assertSame('certificate data', Base64::fromPEM($pem));
    }

    public function testFromPEM_withPrivateKey()
    {
        $pem = "-----BEGIN PRIVATE KEY-----\n" .
               "cHJpdmF0ZSBrZXkgZGF0YQ==\n" .
               "-----END PRIVATE KEY-----\n";
        $this->assertSame('private key data', Base64::fromPEM($pem));
    }

    public function testFromPEM_withWhitespace()
    {
        $pem = " \n -----BEGIN TEST----- \n Y2VydGlmaWNhdGUgZGF0YQ== \n -----END TEST----- \n ";
        $this->assertSame('certificate data', Base64::fromPEM($pem));
    }

    public function testFromPEM_withMultilineData()
    {
        $pem = "-----BEGIN TEST-----\n" .
               "AAAABBBBCCCC\n" .
               "DDDDEEEEFFFF\n" .
               "-----END TEST-----\n";
        $this->assertSame(base64_decode("AAAABBBBCCCCDDDDEEEEFFFF"), Base64::fromPEM($pem));
    }

    public function testFromPEM_withInvalidFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('输入不是有效的PEM格式');
        Base64::fromPEM('not a PEM format');
    }

    public function testFromPEM_withInvalidBase64Data()
    {
        $pem = "-----BEGIN TEST-----\n" .
               "not a valid base64!\n" .
               "-----END TEST-----\n";
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('PEM格式中的Base64数据无效');
        Base64::fromPEM($pem);
    }
}
