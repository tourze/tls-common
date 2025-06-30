<?php

namespace Tourze\TLSCommon\Tests\Utils;

use Tourze\TLSCommon\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Utils\Hex;

final class HexTest extends TestCase
{
    public function testEncode_withDefaultParameters()
    {
        $this->assertSame('', Hex::encode(''));
        $this->assertSame('68656c6c6f', Hex::encode('hello'));
        $this->assertSame('00ff', Hex::encode("\x00\xff"));
    }

    public function testEncode_withUppercase()
    {
        $this->assertSame('', Hex::encode('', true));
        $this->assertSame('68656C6C6F', Hex::encode('hello', true));
        $this->assertSame('00FF', Hex::encode("\x00\xff", true));
    }

    public function testDecode_withBasicHexString()
    {
        $this->assertSame('hello', Hex::decode('68656c6c6f'));
    }

    public function testDecode_withBinaryData()
    {
        $this->assertSame("\x00\xff", Hex::decode('00ff'));
    }

    public function testDecode_withSpaces()
    {
        $this->assertSame('hello', Hex::decode('68 65 6c 6c 6f'));
    }

    public function testDecode_withOddLength()
    {
        $this->assertSame("\x0a\xbc", Hex::decode('abc'));
    }

    public function testDecode_withInvalidCharacters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('输入不是有效的十六进制字符串');
        Hex::decode('not hex');
    }

    public function testFormatHex_withDefaultParameters()
    {
        $this->assertSame('', Hex::formatHex(''));
        $this->assertSame('68 65 6c 6c 6f', Hex::formatHex('hello'));
        $this->assertSame('00 ff', Hex::formatHex("\x00\xff"));
    }

    public function testFormatHex_withCustomSeparator()
    {
        $this->assertSame('', Hex::formatHex('', ':'));
        $this->assertSame('68:65:6c:6c:6f', Hex::formatHex('hello', ':'));
        $this->assertSame('00:ff', Hex::formatHex("\x00\xff", ':'));
    }

    public function testFormatHex_withUppercase()
    {
        $this->assertSame('', Hex::formatHex('', ' ', true));
        $this->assertSame('68 65 6C 6C 6F', Hex::formatHex('hello', ' ', true));
        $this->assertSame('00 FF', Hex::formatHex("\x00\xff", ' ', true));
    }

    public function testHexDump_withEmptyData()
    {
        $this->assertSame('(空)', Hex::hexDump(''));
    }

    public function testHexDump_withSingleLine()
    {
        $dump = Hex::hexDump('hello world', true, 16);
        // 我们只检查格式而不是严格的字符串匹配，因为格式化可能略有不同
        $this->assertStringContainsString('00000000', $dump);
        $this->assertStringContainsString('68 65 6C 6C 6F 20 77 6F', $dump);
        $this->assertStringContainsString('|hello world', $dump);
    }

    public function testHexDump_withMultipleLines()
    {
        $data = str_repeat('abcdefghijklmnop', 2);
        $dump = Hex::hexDump($data, true, 16);
        
        $this->assertStringContainsString('00000000', $dump);
        $this->assertStringContainsString('61 62 63 64 65 66 67 68', $dump);
        $this->assertStringContainsString('|abcdefgh', $dump);
        
        $this->assertStringContainsString('00000010', $dump);
        $this->assertStringContainsString('61 62 63 64 65 66 67 68', $dump);
        $this->assertStringContainsString('|abcdefgh', $dump);
    }

    public function testHexDump_withCustomBytesPerLine()
    {
        $data = 'abcdefghijklmnop';
        $dump = Hex::hexDump($data, true, 8);
        
        $this->assertStringContainsString('00000000', $dump);
        $this->assertStringContainsString('61 62 63 64', $dump);
        $this->assertStringContainsString('|abcd', $dump);
        
        $this->assertStringContainsString('00000008', $dump);
        $this->assertStringContainsString('69 6A 6B 6C', $dump);
        $this->assertStringContainsString('|ijkl', $dump);
    }

    public function testHexDump_withoutAscii()
    {
        $data = 'abcdefgh';
        $dump = Hex::hexDump($data, false, 8);
        
        $this->assertStringContainsString('00000000', $dump);
        $this->assertStringContainsString('61 62 63 64', $dump);
        $this->assertStringNotContainsString('|abcdefgh', $dump);
    }

    public function testHexDump_withNonPrintableCharacters()
    {
        $data = "abc\x00\x01\x02def";
        $dump = Hex::hexDump($data, true, 16);
        
        $this->assertStringContainsString('00000000', $dump);
        $this->assertStringContainsString('61 62 63 00 01 02 64 65', $dump);
        $this->assertStringContainsString('|abc...def', $dump);
    }

    public function testHexDump_withPartialLine()
    {
        $data = 'abcde';
        $dump = Hex::hexDump($data, true, 16);
        
        $this->assertStringContainsString('00000000', $dump);
        $this->assertStringContainsString('61 62 63 64 65', $dump);
        $this->assertStringContainsString('|abcde', $dump);
    }
}
