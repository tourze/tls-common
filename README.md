# TLS Common

[English](README.md) | [中文](README.zh-CN.md)

[![PHP Version](https://img.shields.io/packagist/php-v/tourze/tls-common.svg?style=flat-square)]()
[![License](https://img.shields.io/packagist/l/tourze/tls-common.svg?style=flat-square)](LICENSE)
[![Latest Version](https://img.shields.io/packagist/v/tourze/tls-common.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-common)
[![Build Status](https://img.shields.io/travis/tourze/tls-common/master.svg?style=flat-square)](https://travis-ci.org/tourze/tls-common)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/tls-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/tls-common)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tourze/tls-common.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/tls-common)
[![Downloads](https://img.shields.io/packagist/dt/tourze/tls-common.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-common)

A PHP package that provides the foundation components for TLS protocol implementation projects, 
offering common tools, data structures, and constant definitions related to TLS protocols.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Requirements](#requirements)
- [Configuration](#configuration)
- [Quick Start](#quick-start)
  - [Using TLS Protocol Versions](#using-tls-protocol-versions)
  - [Using Error Codes](#using-error-codes)
  - [Using Byte Buffer](#using-byte-buffer)
  - [Using Encoding/Decoding Tools](#using-encodingdecoding-tools)
  - [Using Protocol Constants](#using-protocol-constants)
- [Main Components](#main-components)
  - [Protocol Version (Version)](#protocol-version-version)
  - [Error Code (ErrorCode)](#error-code-errorcode)
  - [Byte Buffer (ByteBuffer)](#byte-buffer-bytebuffer)
  - [Utility Classes (Utils)](#utility-classes-utils)
  - [Exception Classes (Exception)](#exception-classes-exception)
  - [Protocol Definitions (Protocol)](#protocol-definitions-protocol)
- [Advanced Usage](#advanced-usage)
  - [Custom Error Handling](#custom-error-handling)
  - [Creating Custom Protocol Messages](#creating-custom-protocol-messages)
  - [Performance Optimization](#performance-optimization)
- [Contributing](#contributing)
- [License](#license)

## Features

- 📋 TLS protocol version constant definitions (SSL 3.0 to TLS 1.3)
- 🔢 Standardized error codes and message definitions
- 🔧 Binary data processing tools (ByteBuffer)
- 🌐 Base64 and hexadecimal encoding/decoding tools
- 🚨 Specialized TLS exception class hierarchy
- 📦 Protocol data structure definitions (Alert, Handshake, Content Type, etc.)
- 🔒 Backward-compatible API design

## Installation

```bash
composer require tourze/tls-common
```

## Requirements

- PHP 8.1+
- ext-ctype extension

## Configuration

No additional configuration is required. Simply install the package and start using the provided classes and constants.

## Quick Start

### Using TLS Protocol Versions

```php
<?php

use Tourze\TLSCommon\Version;

// Check protocol version
$version = Version::TLS_1_2;
echo $version->asString(); // Output: TLS 1.2
echo $version->getLabel(); // Output: TLS 1.2

// Check if version is supported
if ($version->isSupported()) {
    echo 'This version is supported';
}

// Get version from integer value
$version = Version::fromInt(0x0303);
if ($version !== null) {
    echo $version->asString(); // Output: TLS 1.2
}
```

### Using Error Codes

```php
<?php

use Tourze\TLSCommon\ErrorCode;

// Get error message
$errorMessage = ErrorCode::getMessage(ErrorCode::HANDSHAKE_FAILURE);
echo $errorMessage; // Output: Handshake failure

// Use error codes
if ($result === ErrorCode::SUCCESS) {
    echo 'Operation successful';
} else {
    echo 'Operation failed: ' . ErrorCode::getMessage($result);
}
```

### Using Byte Buffer

```php
<?php

use Tourze\TLSCommon\Utils\ByteBuffer;

// Create buffer and write data
$buffer = new ByteBuffer();
$buffer->writeUint8(0x16)    // Content Type
       ->writeUint16(0x0303)  // TLS Version
       ->writeUint16(5)       // Length
       ->write('Hello');      // Data

// Read data
$buffer->setPosition(0);
$contentType = $buffer->readUint8();
$tlsVersion = $buffer->readUint16();
$length = $buffer->readUint16();
$data = $buffer->read($length);

echo "Content Type: 0x" . dechex($contentType) . "\n";
echo "TLS Version: 0x" . dechex($tlsVersion) . "\n";
echo "Data: " . $data . "\n";
```

### Using Encoding/Decoding Tools

```php
<?php

use Tourze\TLSCommon\Utils\Base64;
use Tourze\TLSCommon\Utils\Hex;

// Base64 encoding/decoding
$data = 'Hello World';
$encoded = Base64::encode($data);
$decoded = Base64::decode($encoded);

// Hexadecimal encoding/decoding
$hexString = Hex::encode($data);
$originalData = Hex::decode($hexString);
```

### Using Protocol Constants

```php
<?php

use Tourze\TLSCommon\Protocol\ContentType;
use Tourze\TLSCommon\Protocol\AlertLevel;
use Tourze\TLSCommon\Protocol\HandshakeType;

// Content type
$contentType = ContentType::HANDSHAKE;
echo $contentType->value; // Output: 22

// Alert level
$alertLevel = AlertLevel::FATAL;
echo $alertLevel->getLabel(); // Output: Fatal error

// Handshake type
$handshakeType = HandshakeType::CLIENT_HELLO;
echo $handshakeType->asString(); // Output: Client Hello
```

## Main Components

### Protocol Version (Version)

Provides enumeration definitions for TLS protocol versions, including all versions from SSL 3.0 to TLS 1.3.

### Error Code (ErrorCode)

Standardized error code definitions, categorized as follows:
- General errors (1-999)
- Protocol errors (1000-1999)
- Cryptographic errors (2000-2999)
- I/O errors (3000-3999)
- Configuration errors (4000-4999)

### Byte Buffer (ByteBuffer)

Provides binary data processing functionality:
- Read/write 8-bit, 16-bit, 24-bit, 32-bit unsigned integers
- Big-endian format support
- Variable-length data read/write
- Position control and buffer management

### Utility Classes (Utils)

- **Base64**: Base64 encoding/decoding tool
- **Hex**: Hexadecimal encoding/decoding tool

### Exception Classes (Exception)

- **TLSException**: Base class for TLS-related exceptions
- **ProtocolException**: Protocol processing exceptions
- **SecurityException**: Security-related exceptions
- **InvalidArgumentException**: Parameter validation exceptions
- **OutOfBoundsException**: Out-of-bounds access exceptions

### Protocol Definitions (Protocol)

- **ContentType**: TLS content type enumeration
- **AlertLevel**: Alert level enumeration
- **AlertDescription**: Alert description enumeration
- **HandshakeType**: Handshake type enumeration
- **TLSVersion**: TLS version protocol interface

## Advanced Usage

### Custom Error Handling

```php
<?php

use Tourze\TLSCommon\Exception\TLSException;
use Tourze\TLSCommon\Exception\ProtocolException;

try {
    // Your TLS operation here
} catch (ProtocolException $e) {
    // Handle protocol-specific errors
    error_log('Protocol error: ' . $e->getMessage());
} catch (TLSException $e) {
    // Handle general TLS errors
    error_log('TLS error: ' . $e->getMessage());
}
```

### Creating Custom Protocol Messages

```php
<?php

use Tourze\TLSCommon\Utils\ByteBuffer;
use Tourze\TLSCommon\Protocol\ContentType;
use Tourze\TLSCommon\Version;

// Create a custom TLS record
$buffer = new ByteBuffer();
$buffer->writeUint8(ContentType::APPLICATION_DATA->value)
       ->writeUint16(Version::TLS_1_2->value)
       ->writeUint16(strlen($payload))
       ->write($payload);

$record = $buffer->getData();
```

### Performance Optimization

For high-performance scenarios, consider pre-allocating ByteBuffer instances:

```php
<?php

use Tourze\TLSCommon\Utils\ByteBuffer;

// Pre-allocate buffer with known size
$buffer = new ByteBuffer(1024);
```

## Contributing

Please submit issue reports and pull requests to improve this package.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
