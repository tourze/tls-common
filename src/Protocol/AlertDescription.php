<?php

declare(strict_types=1);

namespace Tourze\TLSCommon\Protocol;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * TLS警告描述枚举
 *
 * 参考: https://www.rfc-editor.org/rfc/rfc8446#section-6.2
 */
enum AlertDescription: int implements Itemable, Labelable, Selectable
{
    use ItemTrait;
    use SelectTrait;
    /**
     * 关闭通知
     *
     * 表示发送方不会再在此连接上发送消息
     * 警告级别：警告
     */
    case CLOSE_NOTIFY = 0;

    /**
     * 意外消息
     *
     * 表示收到了不适当的消息
     * 警告级别：致命
     */
    case UNEXPECTED_MESSAGE = 10;

    /**
     * 错误的MAC
     *
     * 表示收到了无法验证的带有MAC的记录
     * 警告级别：致命
     */
    case BAD_RECORD_MAC = 20;

    /**
     * 解密失败
     *
     * TLS 1.0中使用，后被DECRYPTION_FAILED_RESERVED替代
     * 警告级别：致命
     */
    case DECRYPTION_FAILED = 21;

    /**
     * 记录溢出
     *
     * 表示收到的TLS记录长度超过了允许的最大长度
     * 警告级别：致命
     */
    case RECORD_OVERFLOW = 22;

    /**
     * 解压缩失败
     *
     * 表示解压缩函数接收到了不正确的输入
     * 警告级别：致命
     */
    case DECOMPRESSION_FAILURE = 30;

    /**
     * 握手失败
     *
     * 表示发送方无法协商可接受的安全参数
     * 警告级别：致命
     */
    case HANDSHAKE_FAILURE = 40;

    /**
     * 无证书
     *
     * 已弃用
     */
    case NO_CERTIFICATE = 41;

    /**
     * 错误证书
     *
     * 表示证书损坏、包含签名不符合特定算法等
     * 警告级别：致命
     */
    case BAD_CERTIFICATE = 42;

    /**
     * 不支持的证书
     *
     * 表示不支持收到的证书类型
     * 警告级别：致命
     */
    case UNSUPPORTED_CERTIFICATE = 43;

    /**
     * 证书吊销
     *
     * 表示证书已被其签名者吊销
     * 警告级别：致命
     */
    case CERTIFICATE_REVOKED = 44;

    /**
     * 证书过期
     *
     * 表示证书已过期或当前尚未有效
     * 警告级别：致命
     */
    case CERTIFICATE_EXPIRED = 45;

    /**
     * 未知证书
     *
     * 表示出现了一些其他未指定的与证书相关的问题
     * 警告级别：致命
     */
    case CERTIFICATE_UNKNOWN = 46;

    /**
     * 非法参数
     *
     * 表示某个字段超出范围或与其他字段不一致
     * 警告级别：致命
     */
    case ILLEGAL_PARAMETER = 47;

    /**
     * 未知CA
     *
     * 表示无法找到CA证书的有效链
     * 警告级别：致命
     */
    case UNKNOWN_CA = 48;

    /**
     * 拒绝访问
     *
     * 表示收到了有效证书，但应用程序指示拒绝协商
     * 警告级别：致命
     */
    case ACCESS_DENIED = 49;

    /**
     * 解码错误
     *
     * 表示消息无法解码，因为某些字段超出范围或长度不正确
     * 警告级别：致命
     */
    case DECODE_ERROR = 50;

    /**
     * 解密错误
     *
     * 表示握手加密操作失败
     * 警告级别：致命
     */
    case DECRYPT_ERROR = 51;

    /**
     * 协议版本
     *
     * 表示协商的协议版本不受支持
     * 警告级别：致命
     */
    case PROTOCOL_VERSION = 70;

    /**
     * 安全性不足
     *
     * 表示服务器需要加密强度高于客户端支持的加密强度
     * 警告级别：致命
     */
    case INSUFFICIENT_SECURITY = 71;

    /**
     * 内部错误
     *
     * 表示与对等方无关的内部错误
     * 警告级别：致命
     */
    case INTERNAL_ERROR = 80;

    /**
     * 不适当的回退
     *
     * 表示客户端尝试进行非法协议版本降级
     * 警告级别：致命
     */
    case INAPPROPRIATE_FALLBACK = 86;

    /**
     * 用户取消
     *
     * 表示握手被应用程序取消
     * 警告级别：致命
     */
    case USER_CANCELED = 90;

    /**
     * 缺少扩展
     *
     * 表示客户端在ClientHello消息中发送了不符合强制要求的扩展
     * 警告级别：致命
     */
    case MISSING_EXTENSION = 109;

    /**
     * 不支持的扩展
     *
     * 表示收到了不受支持的扩展
     * 警告级别：致命
     */
    case UNSUPPORTED_EXTENSION = 110;

    /**
     * 认证消息过长
     *
     * 表示证书链长度超过了允许的最大长度，或字段长度不一致
     * 警告级别：致命
     */
    case CERTIFICATE_UNOBTAINABLE = 111;

    /**
     * 不认识的名称
     *
     * 表示服务器不认识客户端在服务器名称扩展中发送的名称
     * 警告级别：致命
     */
    case UNRECOGNIZED_NAME = 112;

    /**
     * 错误的证书状态响应
     *
     * 表示服务器在证书状态请求中提供了无效或不可接受的OCSP响应
     * 警告级别：致命
     */
    case BAD_CERTIFICATE_STATUS_RESPONSE = 113;

    /**
     * 错误的证书哈希值
     *
     * 表示服务器在证书链中提供的证书哈希不匹配预期值
     * 警告级别：致命
     */
    case BAD_CERTIFICATE_HASH_VALUE = 114;

    /**
     * 未知的PSK身份
     *
     * 表示无法从PSK包提供的PSK身份中找到匹配的密钥
     * 警告级别：致命
     */
    case UNKNOWN_PSK_IDENTITY = 115;

    /**
     * 证书需要
     *
     * 表示需要客户端提供证书，但未收到任何证书
     * 警告级别：致命
     */
    case CERTIFICATE_REQUIRED = 116;

    /**
     * 无应用协议
     *
     * 表示服务器不支持客户端宣传的任何应用协议
     * 警告级别：致命
     */
    case NO_APPLICATION_PROTOCOL = 120;

    /**
     * 将警告描述枚举转换为字符串表示
     */
    public function asString(): string
    {
        return match ($this) {
            self::CLOSE_NOTIFY => 'close_notify',
            self::UNEXPECTED_MESSAGE => 'unexpected_message',
            self::BAD_RECORD_MAC => 'bad_record_mac',
            self::DECRYPTION_FAILED => 'decryption_failed',
            self::RECORD_OVERFLOW => 'record_overflow',
            self::DECOMPRESSION_FAILURE => 'decompression_failure',
            self::HANDSHAKE_FAILURE => 'handshake_failure',
            self::NO_CERTIFICATE => 'no_certificate',
            self::BAD_CERTIFICATE => 'bad_certificate',
            self::UNSUPPORTED_CERTIFICATE => 'unsupported_certificate',
            self::CERTIFICATE_REVOKED => 'certificate_revoked',
            self::CERTIFICATE_EXPIRED => 'certificate_expired',
            self::CERTIFICATE_UNKNOWN => 'certificate_unknown',
            self::ILLEGAL_PARAMETER => 'illegal_parameter',
            self::UNKNOWN_CA => 'unknown_ca',
            self::ACCESS_DENIED => 'access_denied',
            self::DECODE_ERROR => 'decode_error',
            self::DECRYPT_ERROR => 'decrypt_error',
            self::PROTOCOL_VERSION => 'protocol_version',
            self::INSUFFICIENT_SECURITY => 'insufficient_security',
            self::INTERNAL_ERROR => 'internal_error',
            self::INAPPROPRIATE_FALLBACK => 'inappropriate_fallback',
            self::USER_CANCELED => 'user_canceled',
            self::MISSING_EXTENSION => 'missing_extension',
            self::UNSUPPORTED_EXTENSION => 'unsupported_extension',
            self::CERTIFICATE_UNOBTAINABLE => 'certificate_unobtainable',
            self::UNRECOGNIZED_NAME => 'unrecognized_name',
            self::BAD_CERTIFICATE_STATUS_RESPONSE => 'bad_certificate_status_response',
            self::BAD_CERTIFICATE_HASH_VALUE => 'bad_certificate_hash_value',
            self::UNKNOWN_PSK_IDENTITY => 'unknown_psk_identity',
            self::CERTIFICATE_REQUIRED => 'certificate_required',
            self::NO_APPLICATION_PROTOCOL => 'no_application_protocol',
        };
    }

    /**
     * 从整数值获取警告描述枚举
     */
    public static function fromInt(int $description): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $description) {
                return $case;
            }
        }

        return null;
    }

    /**
     * 获取警告级别
     */
    public function getLevel(): AlertLevel
    {
        return match ($this) {
            self::CLOSE_NOTIFY => AlertLevel::WARNING,
            default => AlertLevel::FATAL,
        };
    }

    /**
     * 向后兼容方法：将警告描述转换为字符串表示
     */
    public static function toString(int $description): string
    {
        $enum = self::fromInt($description);
        if (null !== $enum) {
            return $enum->asString();
        }

        return sprintf('未知警告描述(0x%02X)', $description);
    }

    /**
     * 获取警告描述的中文标签
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::CLOSE_NOTIFY => '关闭通知',
            self::UNEXPECTED_MESSAGE => '意外消息',
            self::BAD_RECORD_MAC => '错误的MAC',
            self::DECRYPTION_FAILED => '解密失败',
            self::RECORD_OVERFLOW => '记录溢出',
            self::DECOMPRESSION_FAILURE => '解压缩失败',
            self::HANDSHAKE_FAILURE => '握手失败',
            self::NO_CERTIFICATE => '无证书',
            self::BAD_CERTIFICATE => '错误证书',
            self::UNSUPPORTED_CERTIFICATE => '不支持的证书',
            self::CERTIFICATE_REVOKED => '证书吊销',
            self::CERTIFICATE_EXPIRED => '证书过期',
            self::CERTIFICATE_UNKNOWN => '未知证书',
            self::ILLEGAL_PARAMETER => '非法参数',
            self::UNKNOWN_CA => '未知CA',
            self::ACCESS_DENIED => '拒绝访问',
            self::DECODE_ERROR => '解码错误',
            self::DECRYPT_ERROR => '解密错误',
            self::PROTOCOL_VERSION => '协议版本',
            self::INSUFFICIENT_SECURITY => '安全性不足',
            self::INTERNAL_ERROR => '内部错误',
            self::INAPPROPRIATE_FALLBACK => '不适当的回退',
            self::USER_CANCELED => '用户取消',
            self::MISSING_EXTENSION => '缺少扩展',
            self::UNSUPPORTED_EXTENSION => '不支持的扩展',
            self::CERTIFICATE_UNOBTAINABLE => '认证消息过长',
            self::UNRECOGNIZED_NAME => '不认识的名称',
            self::BAD_CERTIFICATE_STATUS_RESPONSE => '错误的证书状态响应',
            self::BAD_CERTIFICATE_HASH_VALUE => '错误的证书哈希值',
            self::UNKNOWN_PSK_IDENTITY => '未知的PSK身份',
            self::CERTIFICATE_REQUIRED => '证书需要',
            self::NO_APPLICATION_PROTOCOL => '无应用协议',
        };
    }
}
