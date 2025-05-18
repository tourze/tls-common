<?php

namespace Tourze\TLSCommon\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Version;

final class VersionTest extends TestCase
{
    public function testVersionConstants()
    {
        $this->assertSame(0x0300, Version::SSL_3_0->value);
        $this->assertSame(0x0301, Version::TLS_1_0->value);
        $this->assertSame(0x0302, Version::TLS_1_1->value);
        $this->assertSame(0x0303, Version::TLS_1_2->value);
        $this->assertSame(0x0304, Version::TLS_1_3->value);
    }

    public function testAsString()
    {
        $this->assertSame('SSL 3.0', Version::SSL_3_0->asString());
        $this->assertSame('TLS 1.0', Version::TLS_1_0->asString());
        $this->assertSame('TLS 1.1', Version::TLS_1_1->asString());
        $this->assertSame('TLS 1.2', Version::TLS_1_2->asString());
        $this->assertSame('TLS 1.3', Version::TLS_1_3->asString());
    }

    public function testFromInt_withValidValues()
    {
        $this->assertSame(Version::SSL_3_0, Version::fromInt(0x0300));
        $this->assertSame(Version::TLS_1_0, Version::fromInt(0x0301));
        $this->assertSame(Version::TLS_1_1, Version::fromInt(0x0302));
        $this->assertSame(Version::TLS_1_2, Version::fromInt(0x0303));
        $this->assertSame(Version::TLS_1_3, Version::fromInt(0x0304));
    }

    public function testFromInt_withInvalidValue()
    {
        $this->assertNull(Version::fromInt(0x0000));
        $this->assertNull(Version::fromInt(0x0305));
        $this->assertNull(Version::fromInt(-1));
    }

    public function testIsSupported_forSupportedVersions()
    {
        $this->assertTrue(Version::TLS_1_0->isSupported());
        $this->assertTrue(Version::TLS_1_1->isSupported());
        $this->assertTrue(Version::TLS_1_2->isSupported());
        $this->assertTrue(Version::TLS_1_3->isSupported());
    }

    public function testIsSupported_forUnsupportedVersions()
    {
        $this->assertFalse(Version::SSL_3_0->isSupported());
    }

    public function testToString_withValidValues()
    {
        $this->assertSame('SSL 3.0', Version::toString(0x0300));
        $this->assertSame('TLS 1.0', Version::toString(0x0301));
        $this->assertSame('TLS 1.1', Version::toString(0x0302));
        $this->assertSame('TLS 1.2', Version::toString(0x0303));
        $this->assertSame('TLS 1.3', Version::toString(0x0304));
    }

    public function testToString_withInvalidValue()
    {
        $this->assertSame('未知版本(0x0000)', Version::toString(0x0000));
        $this->assertSame('未知版本(0x0305)', Version::toString(0x0305));
        $this->assertSame('未知版本(0xFFFF)', Version::toString(0xFFFF));
    }

    public function testIsSupportedVersion_withValidValues()
    {
        $this->assertFalse(Version::isSupportedVersion(0x0300));
        $this->assertTrue(Version::isSupportedVersion(0x0301));
        $this->assertTrue(Version::isSupportedVersion(0x0302));
        $this->assertTrue(Version::isSupportedVersion(0x0303));
        $this->assertTrue(Version::isSupportedVersion(0x0304));
    }

    public function testIsSupportedVersion_withInvalidValues()
    {
        $this->assertFalse(Version::isSupportedVersion(0x0000));
        $this->assertFalse(Version::isSupportedVersion(0x0305));
        $this->assertFalse(Version::isSupportedVersion(-1));
    }
}
