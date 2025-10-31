<?php

declare(strict_types=1);

namespace Tourze\TLSCommon;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;
use Tourze\TLSCommon\Protocol\TLSVersion;

/**
 * TLS协议版本枚举（向后兼容）
 *
 * @deprecated 请使用 Tourze\TLSCommon\Protocol\TLSVersion 代替
 *
 * 这个类仅为向后兼容而存在，新代码应该使用 Protocol\TLSVersion
 */
enum Version: int implements Itemable, Labelable, Selectable
{
    use ItemTrait;
    use SelectTrait;

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
        return $this->toTLSVersion()->getName();
    }

    /**
     * 从整数值获取版本枚举
     *
     * @param int $version 版本号整数值
     *
     * @return self|null 对应的枚举值，如果不存在则返回null
     */
    public static function fromInt(int $version): ?self
    {
        return self::tryFrom($version);
    }

    /**
     * 检查版本是否受支持
     */
    public function isSupported(): bool
    {
        return $this->toTLSVersion()->isSupported();
    }

    /**
     * 向后兼容方法：将版本号转换为字符串表示
     */
    public static function toString(int $version): string
    {
        $enum = self::tryFrom($version);
        if (null !== $enum) {
            return $enum->asString();
        }

        return sprintf('未知版本(0x%04X)', $version);
    }

    /**
     * 向后兼容方法：检查版本是否受支持
     */
    public static function isSupportedVersion(int $version): bool
    {
        $enum = self::tryFrom($version);
        if (null !== $enum) {
            return $enum->isSupported();
        }

        return false;
    }

    /**
     * 获取版本的中文标签
     */
    public function getLabel(): string
    {
        return $this->toTLSVersion()->getLabel();
    }

    /**
     * 转换为TLSVersion枚举
     */
    private function toTLSVersion(): TLSVersion
    {
        return TLSVersion::from($this->value);
    }
}
