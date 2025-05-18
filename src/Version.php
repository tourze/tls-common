<?php

namespace Tourze\TLSCommon;

/**
 * TLS协议版本枚举
 *
 * 参考: https://www.rfc-editor.org/rfc/rfc8446
 */
enum Version: int
{
    /**
     * SSL 3.0 版本号
     */
    case SSL_3_0 = 0x0300;

    /**
     * TLS 1.0 版本号
     */
    case TLS_1_0 = 0x0301;

    /**
     * TLS 1.1 版本号
     */
    case TLS_1_1 = 0x0302;

    /**
     * TLS 1.2 版本号
     */
    case TLS_1_2 = 0x0303;

    /**
     * TLS 1.3 版本号
     */
    case TLS_1_3 = 0x0304;

    /**
     * 将版本枚举转换为字符串表示
     */
    public function asString(): string
    {
        return match ($this) {
            self::SSL_3_0 => 'SSL 3.0',
            self::TLS_1_0 => 'TLS 1.0',
            self::TLS_1_1 => 'TLS 1.1',
            self::TLS_1_2 => 'TLS 1.2',
            self::TLS_1_3 => 'TLS 1.3',
        };
    }

    /**
     * 从整数值获取版本枚举
     *
     * @param int $version 版本号整数值
     * @return self|null 对应的枚举值，如果不存在则返回null
     */
    public static function fromInt(int $version): ?self
    {
        return match ($version) {
            self::SSL_3_0->value => self::SSL_3_0,
            self::TLS_1_0->value => self::TLS_1_0,
            self::TLS_1_1->value => self::TLS_1_1,
            self::TLS_1_2->value => self::TLS_1_2,
            self::TLS_1_3->value => self::TLS_1_3,
            default => null,
        };
    }

    /**
     * 检查版本是否受支持
     */
    public function isSupported(): bool
    {
        return match ($this) {
            self::TLS_1_0, self::TLS_1_1, self::TLS_1_2, self::TLS_1_3 => true,
            default => false,
        };
    }

    /**
     * 向后兼容方法：将版本号转换为字符串表示
     */
    public static function toString(int $version): string
    {
        $enum = self::fromInt($version);
        if ($enum !== null) {
            return $enum->asString();
        }

        return sprintf('未知版本(0x%04X)', $version);
    }

    /**
     * 向后兼容方法：检查版本是否受支持
     */
    public static function isSupportedVersion(int $version): bool
    {
        $enum = self::fromInt($version);
        if ($enum !== null) {
            return $enum->isSupported();
        }

        return false;
    }
}
