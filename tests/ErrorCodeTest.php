<?php

namespace Tourze\TLSCommon\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\ErrorCode;

final class ErrorCodeTest extends TestCase
{
    public function testErrorCodeConstants()
    {
        // 通用错误常量测试
        $this->assertSame(0, ErrorCode::SUCCESS);
        $this->assertSame(1, ErrorCode::UNKNOWN_ERROR);
        $this->assertSame(2, ErrorCode::NOT_IMPLEMENTED);

        // 协议错误常量测试
        $this->assertSame(1000, ErrorCode::PROTOCOL_ERROR);
        $this->assertSame(1001, ErrorCode::UNEXPECTED_MESSAGE);
        $this->assertSame(1002, ErrorCode::BAD_RECORD_MAC);

        // 加密错误常量测试
        $this->assertSame(2000, ErrorCode::CRYPTO_ERROR);
        $this->assertSame(2001, ErrorCode::INVALID_KEY);
        $this->assertSame(2002, ErrorCode::INVALID_SIGNATURE);

        // I/O错误常量测试
        $this->assertSame(3000, ErrorCode::IO_ERROR);
        $this->assertSame(3001, ErrorCode::NETWORK_ERROR);
        $this->assertSame(3002, ErrorCode::CONNECTION_CLOSED);

        // 配置错误常量测试
        $this->assertSame(4000, ErrorCode::CONFIG_ERROR);
        $this->assertSame(4001, ErrorCode::INVALID_CONFIGURATION);
        $this->assertSame(4002, ErrorCode::UNSUPPORTED_CIPHER);
    }

    public function testGetMessage_withValidErrorCodes()
    {
        // 通用错误消息测试
        $this->assertSame('成功', ErrorCode::getMessage(ErrorCode::SUCCESS));
        $this->assertSame('未知错误', ErrorCode::getMessage(ErrorCode::UNKNOWN_ERROR));
        $this->assertSame('功能未实现', ErrorCode::getMessage(ErrorCode::NOT_IMPLEMENTED));
        $this->assertSame('内部错误', ErrorCode::getMessage(ErrorCode::INTERNAL_ERROR));
        $this->assertSame('操作超时', ErrorCode::getMessage(ErrorCode::TIMEOUT));
        $this->assertSame('内存不足', ErrorCode::getMessage(ErrorCode::OUT_OF_MEMORY));

        // 协议错误消息测试
        $this->assertSame('协议错误', ErrorCode::getMessage(ErrorCode::PROTOCOL_ERROR));
        $this->assertSame('意外消息', ErrorCode::getMessage(ErrorCode::UNEXPECTED_MESSAGE));
        $this->assertSame('记录MAC错误', ErrorCode::getMessage(ErrorCode::BAD_RECORD_MAC));

        // 加密错误消息测试
        $this->assertSame('加密错误', ErrorCode::getMessage(ErrorCode::CRYPTO_ERROR));
        $this->assertSame('无效的密钥', ErrorCode::getMessage(ErrorCode::INVALID_KEY));
        $this->assertSame('无效的签名', ErrorCode::getMessage(ErrorCode::INVALID_SIGNATURE));

        // I/O错误消息测试
        $this->assertSame('I/O错误', ErrorCode::getMessage(ErrorCode::IO_ERROR));
        $this->assertSame('网络错误', ErrorCode::getMessage(ErrorCode::NETWORK_ERROR));
        $this->assertSame('连接已关闭', ErrorCode::getMessage(ErrorCode::CONNECTION_CLOSED));

        // 配置错误消息测试
        $this->assertSame('配置错误', ErrorCode::getMessage(ErrorCode::CONFIG_ERROR));
        $this->assertSame('无效的配置', ErrorCode::getMessage(ErrorCode::INVALID_CONFIGURATION));
        $this->assertSame('不支持的加密套件', ErrorCode::getMessage(ErrorCode::UNSUPPORTED_CIPHER));
    }

    public function testGetMessage_withInvalidErrorCode()
    {
        // 测试未定义的错误码
        $this->assertSame('未定义的错误(5000)', ErrorCode::getMessage(5000));
        $this->assertSame('未定义的错误(-1)', ErrorCode::getMessage(-1));
        $this->assertSame('未定义的错误(999999)', ErrorCode::getMessage(999999));
    }
}
