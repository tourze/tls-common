<?php

namespace Tourze\TLSCommon\Protocol;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * TLS记录层内容类型枚举
 *
 * 参考: https://www.rfc-editor.org/rfc/rfc8446#section-5.1
 */
enum ContentType: int implements Itemable, Labelable, Selectable
{
    use ItemTrait;
    use SelectTrait;
    /**
     * 变更密码规范协议
     */
    case CHANGE_CIPHER_SPEC = 20;

    /**
     * 警告协议
     */
    case ALERT = 21;

    /**
     * 握手协议
     */
    case HANDSHAKE = 22;

    /**
     * 应用数据协议
     */
    case APPLICATION_DATA = 23;

    /**
     * 心跳协议
     *
     * 参考: https://www.rfc-editor.org/rfc/rfc6520
     */
    case HEARTBEAT = 24;

    /**
     * 将内容类型枚举转换为字符串表示
     */
    public function asString(): string
    {
        return match ($this) {
            self::CHANGE_CIPHER_SPEC => 'ChangeCipherSpec',
            self::ALERT => 'Alert',
            self::HANDSHAKE => 'Handshake',
            self::APPLICATION_DATA => 'ApplicationData',
            self::HEARTBEAT => 'Heartbeat',
        };
    }

    /**
     * 从整数值获取内容类型枚举
     *
     * @param int $type 内容类型整数值
     * @return self|null 对应的枚举值，如果不存在则返回null
     */
    public static function fromInt(int $type): ?self
    {
        return match ($type) {
            self::CHANGE_CIPHER_SPEC->value => self::CHANGE_CIPHER_SPEC,
            self::ALERT->value => self::ALERT,
            self::HANDSHAKE->value => self::HANDSHAKE,
            self::APPLICATION_DATA->value => self::APPLICATION_DATA,
            self::HEARTBEAT->value => self::HEARTBEAT,
            default => null,
        };
    }

    /**
     * 向后兼容方法：将内容类型转换为字符串表示
     */
    public static function toString(int $type): string
    {
        $enum = self::fromInt($type);
        if ($enum !== null) {
            return $enum->asString();
        }

        return sprintf('未知内容类型(0x%02X)', $type);
    }

    /**
     * TLS 1.3中的应用数据（用于0-RTT数据）
     * 注意: 在枚举中不能有两个相同的值，所以这里以常量形式提供
     *
     * 参考: https://www.rfc-editor.org/rfc/rfc8446#section-5.1
     */
    public const TLS13_APPLICATION_DATA = 23;

    /**
     * 获取内容类型的中文标签
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::CHANGE_CIPHER_SPEC => '变更密码规范',
            self::ALERT => '警告',
            self::HANDSHAKE => '握手',
            self::APPLICATION_DATA => '应用数据',
            self::HEARTBEAT => '心跳',
        };
    }
}
