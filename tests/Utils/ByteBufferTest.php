<?php

namespace Tourze\TLSCommon\Tests\Utils;

use Tourze\TLSCommon\Exception\InvalidArgumentException;
use Tourze\TLSCommon\Exception\OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Exception\ProtocolException;
use Tourze\TLSCommon\Utils\ByteBuffer;

final class ByteBufferTest extends TestCase
{
    public function testConstructor_withEmptyData()
    {
        $buffer = new ByteBuffer();
        $this->assertSame(0, $buffer->length());
        $this->assertSame(0, $buffer->getPosition());
        $this->assertSame(0, $buffer->remaining());
        $this->assertSame('', $buffer->getBuffer());
    }

    public function testConstructor_withInitialData()
    {
        $buffer = new ByteBuffer('test');
        $this->assertSame(4, $buffer->length());
        $this->assertSame(0, $buffer->getPosition());
        $this->assertSame(4, $buffer->remaining());
        $this->assertSame('test', $buffer->getBuffer());
    }

    public function testReset()
    {
        $buffer = new ByteBuffer('test');
        $buffer->setPosition(2);
        $buffer->reset();
        $this->assertSame(0, $buffer->length());
        $this->assertSame(0, $buffer->getPosition());
        $this->assertSame('', $buffer->getBuffer());
    }

    public function testAppend()
    {
        $buffer = new ByteBuffer();
        $buffer->append('hello');
        $this->assertSame('hello', $buffer->getBuffer());
        $buffer->append(' world');
        $this->assertSame('hello world', $buffer->getBuffer());
    }

    public function testPositionManagement()
    {
        $buffer = new ByteBuffer('test');
        $this->assertSame(0, $buffer->getPosition());
        
        $buffer->setPosition(2);
        $this->assertSame(2, $buffer->getPosition());
        $this->assertSame(2, $buffer->remaining());
        
        $buffer->setPosition(4);
        $this->assertSame(4, $buffer->getPosition());
        $this->assertSame(0, $buffer->remaining());
    }

    public function testSetPosition_withInvalidPositions()
    {
        $buffer = new ByteBuffer('test');
        
        $this->expectException(OutOfBoundsException::class);
        $buffer->setPosition(-1);
    }

    public function testSetPosition_exceedingLength()
    {
        $buffer = new ByteBuffer('test');
        
        $this->expectException(OutOfBoundsException::class);
        $buffer->setPosition(5);
    }

    public function testRead_validCase()
    {
        $buffer = new ByteBuffer('hello world');
        $this->assertSame('hel', $buffer->read(3));
        $this->assertSame(3, $buffer->getPosition());
        $this->assertSame('lo ', $buffer->read(3));
        $this->assertSame(6, $buffer->getPosition());
    }

    public function testRead_withNegativeLength()
    {
        $buffer = new ByteBuffer('test');
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->read(-1);
    }

    public function testRead_exceedingLength()
    {
        $buffer = new ByteBuffer('test');
        
        $this->expectException(OutOfBoundsException::class);
        $buffer->read(5);
    }

    public function testReadUint8()
    {
        $buffer = new ByteBuffer(\chr(0xAB));
        $this->assertSame(0xAB, $buffer->readUint8());
        $this->assertSame(1, $buffer->getPosition());
    }

    public function testReadUint16()
    {
        $buffer = new ByteBuffer(\chr(0xAB) . \chr(0xCD));
        $this->assertSame(0xABCD, $buffer->readUint16());
        $this->assertSame(2, $buffer->getPosition());
    }

    public function testReadUint24()
    {
        $buffer = new ByteBuffer(\chr(0xAB) . \chr(0xCD) . \chr(0xEF));
        $this->assertSame(0xABCDEF, $buffer->readUint24());
        $this->assertSame(3, $buffer->getPosition());
    }

    public function testReadUint32()
    {
        $buffer = new ByteBuffer(\chr(0x12) . \chr(0x34) . \chr(0x56) . \chr(0x78));
        $this->assertSame(0x12345678, $buffer->readUint32());
        $this->assertSame(4, $buffer->getPosition());
    }

    public function testWriteUint8_validValue()
    {
        $buffer = new ByteBuffer();
        $buffer->writeUint8(0xAB);
        $this->assertSame(\chr(0xAB), $buffer->getBuffer());
    }

    public function testWriteUint8_invalidValue()
    {
        $buffer = new ByteBuffer();
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->writeUint8(0x100);
    }

    public function testWriteUint8_negativeValue()
    {
        $buffer = new ByteBuffer();
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->writeUint8(-1);
    }

    public function testWriteUint16_validValue()
    {
        $buffer = new ByteBuffer();
        $buffer->writeUint16(0xABCD);
        $this->assertSame(\chr(0xAB) . \chr(0xCD), $buffer->getBuffer());
    }

    public function testWriteUint16_invalidValue()
    {
        $buffer = new ByteBuffer();
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->writeUint16(0x10000);
    }

    public function testWriteUint24_validValue()
    {
        $buffer = new ByteBuffer();
        $buffer->writeUint24(0xABCDEF);
        $this->assertSame(\chr(0xAB) . \chr(0xCD) . \chr(0xEF), $buffer->getBuffer());
    }

    public function testWriteUint24_invalidValue()
    {
        $buffer = new ByteBuffer();
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->writeUint24(0x1000000);
    }

    public function testWriteUint32_validValue()
    {
        $buffer = new ByteBuffer();
        $buffer->writeUint32(0x12345678);
        $this->assertSame(\chr(0x12) . \chr(0x34) . \chr(0x56) . \chr(0x78), $buffer->getBuffer());
    }

    public function testWriteUint32_negativeValue()
    {
        $buffer = new ByteBuffer();
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->writeUint32(-1);
    }

    public function testWrite()
    {
        $buffer = new ByteBuffer();
        $buffer->write('hello');
        $this->assertSame('hello', $buffer->getBuffer());
        $buffer->write(' world');
        $this->assertSame('hello world', $buffer->getBuffer());
    }

    public function testReadVector_withLength1()
    {
        $buffer = new ByteBuffer(\chr(3) . 'abc');
        $data = $buffer->readVector(1);
        $this->assertSame('abc', $data);
        $this->assertSame(4, $buffer->getPosition());
    }

    public function testReadVector_withLength2()
    {
        $buffer = new ByteBuffer(\chr(0) . \chr(3) . 'abc');
        $data = $buffer->readVector(2);
        $this->assertSame('abc', $data);
        $this->assertSame(5, $buffer->getPosition());
    }

    public function testReadVector_withInvalidLengthBytes()
    {
        $buffer = new ByteBuffer(\chr(3) . 'abc');
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->readVector(0);
    }

    public function testReadVector_withExcessiveLengthBytes()
    {
        $buffer = new ByteBuffer(\chr(3) . 'abc');
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->readVector(4);
    }

    public function testWriteVector_withLength1()
    {
        $buffer = new ByteBuffer();
        $buffer->writeVector('abc', 1);
        $this->assertSame(\chr(3) . 'abc', $buffer->getBuffer());
    }

    public function testWriteVector_withLength2()
    {
        $buffer = new ByteBuffer();
        $buffer->writeVector('abc', 2);
        $this->assertSame(\chr(0) . \chr(3) . 'abc', $buffer->getBuffer());
    }

    public function testWriteVector_withInvalidLengthBytes()
    {
        $buffer = new ByteBuffer();
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->writeVector('abc', 0);
    }

    public function testWriteVector_withExcessiveLengthBytes()
    {
        $buffer = new ByteBuffer();
        
        $this->expectException(InvalidArgumentException::class);
        $buffer->writeVector('abc', 4);
    }

    public function testWriteVector_withDataExceedingMaxLength()
    {
        $buffer = new ByteBuffer();
        $longData = str_repeat('a', 256);
        
        $this->expectException(ProtocolException::class);
        $buffer->writeVector($longData, 1);
    }

    public function testGetRemainingData()
    {
        $buffer = new ByteBuffer('hello world');
        $buffer->read(6);
        $this->assertSame('world', $buffer->getRemainingData());
        $this->assertSame(6, $buffer->getPosition()); // 位置不变
    }
}
