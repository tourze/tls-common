# TLS Common

这个PHP包是TLS协议实现项目的基础组件，提供了TLS协议相关的通用工具、数据结构和常量定义。

## 功能特性

- TLS协议版本常量定义
- 协议数据结构的实现
- 字节流处理和二进制数据解析工具
- 通用工具函数和异常类
- 日志和调试工具
- 标准化的错误代码和消息定义
- 协议接口和抽象类

## 安装

```bash
composer require tourze/tls-common
```

## 使用示例

```php
<?php

use Tourze\TLSCommon\Version;
use Tourze\TLSCommon\Utils\ByteBuffer;

// 使用TLS协议版本常量
if ($negotiatedVersion === Version::TLS_1_2) {
    // TLS 1.2 特定的处理逻辑
}

// 使用字节缓冲区处理二进制数据
$buffer = new ByteBuffer();
$buffer->append($binaryData);
$value = $buffer->readUint16();
```

## 主要组件

### 协议版本常量

`Version` 类定义了TLS协议的版本常量：

- `Version::SSL_3_0` - SSL 3.0
- `Version::TLS_1_0` - TLS 1.0
- `Version::TLS_1_1` - TLS 1.1
- `Version::TLS_1_2` - TLS 1.2
- `Version::TLS_1_3` - TLS 1.3

### 错误处理

`Exception` 命名空间提供了专门的异常类：

- `TLSException` - TLS协议相关异常的基类
- `ProtocolException` - 协议处理过程中的异常
- `SecurityException` - 安全相关的异常

### 数据处理工具

`Utils` 命名空间提供了数据处理相关的工具类：

- `ByteBuffer` - 处理二进制数据的缓冲区
- `Hex` - 十六进制数据转换工具
- `Base64` - Base64编解码工具

### 日志和调试

`Logger` 命名空间提供了日志记录和调试工具：

- `LogLevel` - 日志级别定义
- `LoggerInterface` - 日志接口
- `ConsoleLogger` - 控制台日志实现

## 贡献

欢迎提交问题报告和拉取请求以改进这个包。

## 许可证

本包基于MIT许可证发布。
