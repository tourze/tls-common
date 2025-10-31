<?php

declare(strict_types=1);

namespace Tourze\TLSCommon;

/**
 * TLS错误码定义
 */
final class ErrorCode
{
    // 通用错误 (1-999)
    public const SUCCESS = 0;
    public const UNKNOWN_ERROR = 1;
    public const NOT_IMPLEMENTED = 2;
    public const INTERNAL_ERROR = 3;
    public const TIMEOUT = 4;
    public const OUT_OF_MEMORY = 5;

    // 协议错误 (1000-1999)
    public const PROTOCOL_ERROR = 1000;
    public const UNEXPECTED_MESSAGE = 1001;
    public const BAD_RECORD_MAC = 1002;
    public const DECRYPTION_FAILED = 1003;
    public const RECORD_OVERFLOW = 1004;
    public const DECOMPRESSION_FAILURE = 1005;
    public const HANDSHAKE_FAILURE = 1006;
    public const BAD_CERTIFICATE = 1007;
    public const UNSUPPORTED_CERTIFICATE = 1008;
    public const CERTIFICATE_REVOKED = 1009;
    public const CERTIFICATE_EXPIRED = 1010;
    public const CERTIFICATE_UNKNOWN = 1011;
    public const ILLEGAL_PARAMETER = 1012;
    public const UNKNOWN_CA = 1013;
    public const ACCESS_DENIED = 1014;
    public const DECODE_ERROR = 1015;
    public const DECRYPT_ERROR = 1016;
    public const PROTOCOL_VERSION = 1017;
    public const INSUFFICIENT_SECURITY = 1018;
    public const INTERNAL_ERROR_ALERT = 1019;
    public const USER_CANCELED = 1020;
    public const NO_RENEGOTIATION = 1021;
    public const UNSUPPORTED_EXTENSION = 1022;
    public const CERTIFICATE_UNOBTAINABLE = 1023;
    public const UNRECOGNIZED_NAME = 1024;
    public const BAD_CERTIFICATE_STATUS_RESPONSE = 1025;
    public const BAD_CERTIFICATE_HASH_VALUE = 1026;
    public const UNKNOWN_PSK_IDENTITY = 1027;
    public const CERTIFICATE_REQUIRED = 1028;
    public const NO_APPLICATION_PROTOCOL = 1029;

    // 加密错误 (2000-2999)
    public const CRYPTO_ERROR = 2000;
    public const INVALID_KEY = 2001;
    public const INVALID_SIGNATURE = 2002;
    public const INVALID_CERTIFICATE = 2003;
    public const INVALID_ALGORITHM = 2004;
    public const INSUFFICIENT_ENTROPY = 2005;
    public const KEY_GENERATION_FAILED = 2006;
    public const SIGNATURE_GENERATION_FAILED = 2007;
    public const INVALID_PADDING = 2008;

    // I/O错误 (3000-3999)
    public const IO_ERROR = 3000;
    public const NETWORK_ERROR = 3001;
    public const CONNECTION_CLOSED = 3002;
    public const CONNECTION_RESET = 3003;
    public const CONNECTION_REFUSED = 3004;
    public const HOST_UNREACHABLE = 3005;

    // 配置错误 (4000-4999)
    public const CONFIG_ERROR = 4000;
    public const INVALID_CONFIGURATION = 4001;
    public const UNSUPPORTED_CIPHER = 4002;
    public const UNSUPPORTED_PROTOCOL = 4003;

    /**
     * 错误码对应的错误信息
     * @var array<int, string>
     */
    private static array $errorMessages = [
        self::SUCCESS => '成功',
        self::UNKNOWN_ERROR => '未知错误',
        self::NOT_IMPLEMENTED => '功能未实现',
        self::INTERNAL_ERROR => '内部错误',
        self::TIMEOUT => '操作超时',
        self::OUT_OF_MEMORY => '内存不足',

        self::PROTOCOL_ERROR => '协议错误',
        self::UNEXPECTED_MESSAGE => '意外消息',
        self::BAD_RECORD_MAC => '记录MAC错误',
        self::DECRYPTION_FAILED => '解密失败',
        self::RECORD_OVERFLOW => '记录溢出',
        self::DECOMPRESSION_FAILURE => '解压缩失败',
        self::HANDSHAKE_FAILURE => '握手失败',
        self::BAD_CERTIFICATE => '证书错误',
        self::UNSUPPORTED_CERTIFICATE => '不支持的证书',
        self::CERTIFICATE_REVOKED => '证书已吊销',
        self::CERTIFICATE_EXPIRED => '证书已过期',
        self::CERTIFICATE_UNKNOWN => '未知证书错误',
        self::ILLEGAL_PARAMETER => '非法参数',
        self::UNKNOWN_CA => '未知CA',
        self::ACCESS_DENIED => '访问被拒绝',
        self::DECODE_ERROR => '解码错误',
        self::DECRYPT_ERROR => '解密错误',
        self::PROTOCOL_VERSION => '协议版本错误',
        self::INSUFFICIENT_SECURITY => '安全性不足',
        self::INTERNAL_ERROR_ALERT => '内部错误警告',
        self::USER_CANCELED => '用户取消',
        self::NO_RENEGOTIATION => '不允许重新协商',
        self::UNSUPPORTED_EXTENSION => '不支持的扩展',
        self::CERTIFICATE_UNOBTAINABLE => '无法获取证书',
        self::UNRECOGNIZED_NAME => '无法识别的名称',
        self::BAD_CERTIFICATE_STATUS_RESPONSE => '证书状态响应错误',
        self::BAD_CERTIFICATE_HASH_VALUE => '证书哈希值错误',
        self::UNKNOWN_PSK_IDENTITY => '未知的PSK标识',
        self::CERTIFICATE_REQUIRED => '需要证书',
        self::NO_APPLICATION_PROTOCOL => '无应用协议',

        self::CRYPTO_ERROR => '加密错误',
        self::INVALID_KEY => '无效的密钥',
        self::INVALID_SIGNATURE => '无效的签名',
        self::INVALID_CERTIFICATE => '无效的证书',
        self::INVALID_ALGORITHM => '无效的算法',
        self::INSUFFICIENT_ENTROPY => '熵不足',
        self::KEY_GENERATION_FAILED => '密钥生成失败',
        self::SIGNATURE_GENERATION_FAILED => '签名生成失败',
        self::INVALID_PADDING => '无效的填充',

        self::IO_ERROR => 'I/O错误',
        self::NETWORK_ERROR => '网络错误',
        self::CONNECTION_CLOSED => '连接已关闭',
        self::CONNECTION_RESET => '连接已重置',
        self::CONNECTION_REFUSED => '连接被拒绝',
        self::HOST_UNREACHABLE => '主机不可达',

        self::CONFIG_ERROR => '配置错误',
        self::INVALID_CONFIGURATION => '无效的配置',
        self::UNSUPPORTED_CIPHER => '不支持的加密套件',
        self::UNSUPPORTED_PROTOCOL => '不支持的协议',
    ];

    /**
     * 获取错误码对应的错误信息
     */
    public static function getMessage(int $code): string
    {
        return self::$errorMessages[$code] ?? '未定义的错误(' . $code . ')';
    }
}
