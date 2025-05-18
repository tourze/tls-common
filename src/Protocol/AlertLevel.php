<?php

namespace Tourze\TLSCommon\Protocol;

/**
 * TLS警告级别枚举
 *
 * 参考: https://www.rfc-editor.org/rfc/rfc8446#section-6
 */
enum AlertLevel: int
{
    /**
     * 警告级别
     *
     * 表示对等方发送了可能的警告，但连接仍然可用
     */
    case WARNING = 1;

    /**
     * 致命级别
     *
     * 表示发生了严重错误，连接必须立即关闭
     */
    case FATAL = 2;

    /**
     * 将警告级别枚举转换为字符串表示
     */
    public function asString(): string
    {
        return match ($this) {
            self::WARNING => '警告',
            self::FATAL => '致命',
        };
    }

    /**
     * 从整数值获取警告级别枚举
     */
    public static function fromInt(int $level): ?self
    {
        return match ($level) {
            self::WARNING->value => self::WARNING,
            self::FATAL->value => self::FATAL,
            default => null,
        };
    }

    /**
     * 向后兼容方法：将警告级别转换为字符串表示
     */
    public static function toString(int $level): string
    {
        $enum = self::fromInt($level);
        if ($enum !== null) {
            return $enum->asString();
        }

        return sprintf('未知警告级别(0x%02X)', $level);
    }
}
