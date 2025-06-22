<?php

namespace Tourze\TLSCommon\Utils;

use InvalidArgumentException;
use OutOfBoundsException;
use Tourze\TLSCommon\Exception\ProtocolException;

/**
 * 字节缓冲区类，用于处理二进制数据
 *
 * 提供了读写不同类型数据的方法，特别适用于TLS协议的二进制数据处理
 */
class ByteBuffer
{
    /**
     * 内部缓冲区
     */
    private string $buffer = '';

    /**
     * 当前读取位置
     */
    private int $position = 0;

    /**
     * 创建一个新的ByteBuffer实例
     */
    public function __construct(string $initialData = '')
    {
        if ($initialData !== '') {
            $this->buffer = $initialData;
        }
    }

    /**
     * 重置缓冲区
     */
    public function reset(): void
    {
        $this->buffer = '';
        $this->position = 0;
    }

    /**
     * 向缓冲区添加数据
     */
    public function append(string $data): self
    {
        $this->buffer .= $data;
        return $this;
    }

    /**
     * 获取剩余可读取的字节数
     */
    public function remaining(): int
    {
        return strlen($this->buffer) - $this->position;
    }

    /**
     * 获取缓冲区的总长度
     */
    public function length(): int
    {
        return strlen($this->buffer);
    }

    /**
     * 获取当前读取位置
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * 设置当前读取位置
     */
    public function setPosition(int $position): self
    {
        if ($position < 0 || $position > strlen($this->buffer)) {
            throw new OutOfBoundsException('位置超出缓冲区范围');
        }

        $this->position = $position;
        return $this;
    }

    /**
     * 读取指定长度的字节
     */
    public function read(int $length): string
    {
        if ($length < 0) {
            throw new InvalidArgumentException('长度不能为负数');
        }

        if ($this->position + $length > strlen($this->buffer)) {
            throw new OutOfBoundsException('读取长度超出缓冲区范围');
        }

        $data = substr($this->buffer, $this->position, $length);
        $this->position += $length;
        return $data;
    }

    /**
     * 读取一个字节（8位无符号整数）
     */
    public function readUint8(): int
    {
        $data = $this->read(1);
        return ord($data);
    }

    /**
     * 读取两个字节（16位无符号整数，大端序）
     */
    public function readUint16(): int
    {
        $data = $this->read(2);
        return (ord($data[0]) << 8) | ord($data[1]);
    }

    /**
     * 读取三个字节（24位无符号整数，大端序）
     */
    public function readUint24(): int
    {
        $data = $this->read(3);
        return (ord($data[0]) << 16) | (ord($data[1]) << 8) | ord($data[2]);
    }

    /**
     * 读取四个字节（32位无符号整数，大端序）
     */
    public function readUint32(): int
    {
        $data = $this->read(4);
        // PHP的整数可能是有符号的，所以使用位运算需要特别注意
        $value = ((ord($data[0]) << 24) | (ord($data[1]) << 16) | (ord($data[2]) << 8) | ord($data[3])) & 0xFFFFFFFF;

        return $value;
    }

    /**
     * 将无符号8位整数写入缓冲区
     */
    public function writeUint8(int $value): self
    {
        if ($value < 0 || $value > 0xFF) {
            throw new InvalidArgumentException('值超出8位无符号整数范围');
        }

        $this->buffer .= chr($value);
        return $this;
    }

    /**
     * 将无符号16位整数写入缓冲区（大端序）
     */
    public function writeUint16(int $value): self
    {
        if ($value < 0 || $value > 0xFFFF) {
            throw new InvalidArgumentException('值超出16位无符号整数范围');
        }

        $this->buffer .= chr(($value >> 8) & 0xFF) . chr($value & 0xFF);
        return $this;
    }

    /**
     * 将无符号24位整数写入缓冲区（大端序）
     */
    public function writeUint24(int $value): self
    {
        if ($value < 0 || $value > 0xFFFFFF) {
            throw new InvalidArgumentException('值超出24位无符号整数范围');
        }

        $this->buffer .= chr(($value >> 16) & 0xFF) . chr(($value >> 8) & 0xFF) . chr($value & 0xFF);
        return $this;
    }

    /**
     * 将无符号32位整数写入缓冲区（大端序）
     */
    public function writeUint32(int $value): self
    {
        if ($value < 0) {
            throw new InvalidArgumentException('值不能为负数');
        }

        $this->buffer .= chr(($value >> 24) & 0xFF) . chr(($value >> 16) & 0xFF) .
            chr(($value >> 8) & 0xFF) . chr($value & 0xFF);
        return $this;
    }

    /**
     * 写入二进制数据
     */
    public function write(string $data): self
    {
        $this->buffer .= $data;
        return $this;
    }

    /**
     * 读取可变长度的数据，根据TLS协议规范
     * 这通常用于读取各种TLS结构，如证书、扩展等
     */
    public function readVector(int $lengthBytes): string
    {
        if ($lengthBytes < 1 || $lengthBytes > 3) {
            throw new InvalidArgumentException('长度字节数必须在1-3范围内');
        }

        // 读取长度字段
        $length = match ($lengthBytes) {
            1 => $this->readUint8(),
            2 => $this->readUint16(),
            3 => $this->readUint24(),
        };

        // 读取实际数据
        return $this->read($length);
    }

    /**
     * 写入可变长度的数据，根据TLS协议规范
     */
    public function writeVector(string $data, int $lengthBytes): self
    {
        if ($lengthBytes < 1 || $lengthBytes > 3) {
            throw new InvalidArgumentException('长度字节数必须在1-3范围内');
        }

        $length = strlen($data);
        $maxLength = match ($lengthBytes) {
            1 => 0xFF,
            2 => 0xFFFF,
            3 => 0xFFFFFF,
        };

        if ($length > $maxLength) {
            throw new ProtocolException("数据长度超出范围: {$length} > {$maxLength}");
        }

        // 写入长度字段
        match ($lengthBytes) {
            1 => $this->writeUint8($length),
            2 => $this->writeUint16($length),
            3 => $this->writeUint24($length),
        };

        // 写入实际数据
        return $this->write($data);
    }

    /**
     * 获取缓冲区中的所有数据
     */
    public function getBuffer(): string
    {
        return $this->buffer;
    }

    /**
     * 获取缓冲区中剩余的数据
     */
    public function getRemainingData(): string
    {
        if ($this->position >= strlen($this->buffer)) {
            return '';
        }

        return substr($this->buffer, $this->position);
    }
}
