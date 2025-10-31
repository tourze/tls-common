# TLS Common

[English](README.md) | [中文](README.zh-CN.md)

[![PHP Version](https://img.shields.io/packagist/php-v/tourze/tls-common.svg?style=flat-square)]()
[![License](https://img.shields.io/packagist/l/tourze/tls-common.svg?style=flat-square)](LICENSE)
[![Latest Version](https://img.shields.io/packagist/v/tourze/tls-common.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-common)
[![Build Status](https://img.shields.io/travis/tourze/tls-common/master.svg?style=flat-square)](https://travis-ci.org/tourze/tls-common)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/tls-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/tls-common)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tourze/tls-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/tls-common)
[![Downloads](https://img.shields.io/packagist/dt/tourze/tls-common.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-common)

这个PHP包是TLS协议实现项目的基础组件，提供了TLS协议相关的通用工具、数据结构和常量定义。

## 目录

- [功能特性](#功能特性)
- [安装](#安装)
- [系统要求](#系统要求)
- [依赖](#依赖)
- [使用示例](#使用示例)
- [主要组件](#主要组件)
  - [协议版本常量](#协议版本常量)
  - [错误处理](#错误处理)
  - [数据处理工具](#数据处理工具)
  - [协议常量定义](#协议常量定义)
- [高级用法](#高级用法)
  - [自定义错误处理](#自定义错误处理)
  - [创建自定义协议消息](#创建自定义协议消息)
  - [性能优化](#性能优化)
- [贡献](#贡献)
- [许可证](#许可证)

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

## 系统要求

- PHP 8.1+
- ext-ctype 扩展

## 依赖

本包没有外部依赖，仅依赖 PHP 内置扩展。

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

### 协议常量定义

`Protocol` 命名空间提供了TLS协议相关的常量定义：

- `AlertDescription` - 警告描述常量
- `AlertLevel` - 警告级别常量
- `ContentType` - 内容类型常量
- `HandshakeType` - 握手类型常量
- `TLSVersion` - TLS版本常量

## 高级用法

### 自定义错误处理

```php
<?php

use Tourze\TLSCommon\Exception\TLSException;
use Tourze\TLSCommon\Exception\ProtocolException;

try {
    // 你的 TLS 操作代码
} catch (ProtocolException $e) {
    // 处理协议特定错误
    error_log('协议错误: ' . $e->getMessage());
} catch (TLSException $e) {
    // 处理通用 TLS 错误
    error_log('TLS 错误: ' . $e->getMessage());
}
```

### 创建自定义协议消息

```php
<?php

use Tourze\TLSCommon\Utils\ByteBuffer;
use Tourze\TLSCommon\Protocol\ContentType;
use Tourze\TLSCommon\Version;

// 创建自定义 TLS 记录
$buffer = new ByteBuffer();
$buffer->writeUint8(ContentType::APPLICATION_DATA->value)
       ->writeUint16(Version::TLS_1_2->value)
       ->writeUint16(strlen($payload))
       ->write($payload);

$record = $buffer->getData();
```

### 性能优化

对于高性能场景，考虑预分配 ByteBuffer 实例：

```php
<?php

use Tourze\TLSCommon\Utils\ByteBuffer;

// 使用已知大小预分配缓冲区
$buffer = new ByteBuffer(1024);
```

## 贡献

欢迎提交问题报告和拉取请求以改进这个包。

## 许可证

本包基于MIT许可证发布。
