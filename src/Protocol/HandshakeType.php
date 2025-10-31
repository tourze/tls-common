<?php

declare(strict_types=1);

namespace Tourze\TLSCommon\Protocol;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * TLS握手消息类型枚举
 *
 * 参考: https://www.rfc-editor.org/rfc/rfc8446#section-4
 */
enum HandshakeType: int implements Itemable, Labelable, Selectable
{
    use ItemTrait;
    use SelectTrait;
    /**
     * 客户端Hello消息
     */
    case CLIENT_HELLO = 1;

    /**
     * 服务器Hello消息
     */
    case SERVER_HELLO = 2;

    /**
     * 新会话票据
     *
     * TLS 1.3中不再使用，由NewSessionTicket替代
     */
    case HELLO_VERIFY_REQUEST = 3;

    /**
     * 新会话票据
     */
    case NEW_SESSION_TICKET = 4;

    /**
     * 结束握手消息
     */
    case END_OF_EARLY_DATA = 5;

    /**
     * 加密扩展
     */
    case ENCRYPTED_EXTENSIONS = 8;

    /**
     * 证书请求
     */
    case CERTIFICATE_REQUEST = 13;

    /**
     * 服务器证书
     */
    case CERTIFICATE = 11;

    /**
     * 服务器密钥交换
     */
    case SERVER_KEY_EXCHANGE = 12;

    /**
     * 服务器证书状态
     */
    case CERTIFICATE_STATUS = 22;

    /**
     * 服务器握手完成
     */
    case SERVER_HELLO_DONE = 14;

    /**
     * 证书验证
     */
    case CERTIFICATE_VERIFY = 15;

    /**
     * 客户端密钥交换
     */
    case CLIENT_KEY_EXCHANGE = 16;

    /**
     * 完成消息
     */
    case FINISHED = 20;

    /**
     * 密钥更新
     */
    case KEY_UPDATE = 24;

    /**
     * 消息哈希
     */
    case MESSAGE_HASH = 254;

    /**
     * 将握手类型枚举转换为字符串表示
     */
    public function asString(): string
    {
        return match ($this) {
            self::CLIENT_HELLO => 'ClientHello',
            self::SERVER_HELLO => 'ServerHello',
            self::HELLO_VERIFY_REQUEST => 'HelloVerifyRequest',
            self::NEW_SESSION_TICKET => 'NewSessionTicket',
            self::END_OF_EARLY_DATA => 'EndOfEarlyData',
            self::ENCRYPTED_EXTENSIONS => 'EncryptedExtensions',
            self::CERTIFICATE_REQUEST => 'CertificateRequest',
            self::CERTIFICATE => 'Certificate',
            self::SERVER_KEY_EXCHANGE => 'ServerKeyExchange',
            self::CERTIFICATE_STATUS => 'CertificateStatus',
            self::SERVER_HELLO_DONE => 'ServerHelloDone',
            self::CERTIFICATE_VERIFY => 'CertificateVerify',
            self::CLIENT_KEY_EXCHANGE => 'ClientKeyExchange',
            self::FINISHED => 'Finished',
            self::KEY_UPDATE => 'KeyUpdate',
            self::MESSAGE_HASH => 'MessageHash',
        };
    }

    /**
     * 从整数值获取握手类型枚举
     */
    public static function fromInt(int $type): ?self
    {
        return match ($type) {
            self::CLIENT_HELLO->value => self::CLIENT_HELLO,
            self::SERVER_HELLO->value => self::SERVER_HELLO,
            self::HELLO_VERIFY_REQUEST->value => self::HELLO_VERIFY_REQUEST,
            self::NEW_SESSION_TICKET->value => self::NEW_SESSION_TICKET,
            self::END_OF_EARLY_DATA->value => self::END_OF_EARLY_DATA,
            self::ENCRYPTED_EXTENSIONS->value => self::ENCRYPTED_EXTENSIONS,
            self::CERTIFICATE_REQUEST->value => self::CERTIFICATE_REQUEST,
            self::CERTIFICATE->value => self::CERTIFICATE,
            self::SERVER_KEY_EXCHANGE->value => self::SERVER_KEY_EXCHANGE,
            self::CERTIFICATE_STATUS->value => self::CERTIFICATE_STATUS,
            self::SERVER_HELLO_DONE->value => self::SERVER_HELLO_DONE,
            self::CERTIFICATE_VERIFY->value => self::CERTIFICATE_VERIFY,
            self::CLIENT_KEY_EXCHANGE->value => self::CLIENT_KEY_EXCHANGE,
            self::FINISHED->value => self::FINISHED,
            self::KEY_UPDATE->value => self::KEY_UPDATE,
            self::MESSAGE_HASH->value => self::MESSAGE_HASH,
            default => null,
        };
    }

    /**
     * 向后兼容方法：将握手类型转换为字符串表示
     */
    public static function toString(int $type): string
    {
        $enum = self::fromInt($type);
        if (null !== $enum) {
            return $enum->asString();
        }

        return sprintf('未知握手类型(0x%02X)', $type);
    }

    /**
     * 获取握手类型的中文标签
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::CLIENT_HELLO => '客户端Hello',
            self::SERVER_HELLO => '服务器Hello',
            self::HELLO_VERIFY_REQUEST => 'Hello验证请求',
            self::NEW_SESSION_TICKET => '新会话票据',
            self::END_OF_EARLY_DATA => '早期数据结束',
            self::ENCRYPTED_EXTENSIONS => '加密扩展',
            self::CERTIFICATE => '证书',
            self::SERVER_KEY_EXCHANGE => '服务器密钥交换',
            self::CERTIFICATE_REQUEST => '证书请求',
            self::SERVER_HELLO_DONE => '服务器Hello完成',
            self::CERTIFICATE_VERIFY => '证书验证',
            self::CLIENT_KEY_EXCHANGE => '客户端密钥交换',
            self::FINISHED => '完成',
            self::CERTIFICATE_STATUS => '证书状态',
            self::KEY_UPDATE => '密钥更新',
            self::MESSAGE_HASH => '消息哈希',
        };
    }
}
