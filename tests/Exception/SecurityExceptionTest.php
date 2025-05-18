<?php

namespace Tourze\TLSCommon\Tests\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Exception\SecurityException;
use Tourze\TLSCommon\Exception\TLSException;

final class SecurityExceptionTest extends TestCase
{
    public function testInstanceOfTLSException()
    {
        $exception = new SecurityException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testConstructor_withDefaultParams()
    {
        $exception = new SecurityException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructor_withCustomParams()
    {
        $message = 'Security error message';
        $code = 2001;
        $previous = new Exception('Previous exception');
        
        $exception = new SecurityException($message, $code, $previous);
        
        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
