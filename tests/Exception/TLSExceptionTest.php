<?php

namespace Tourze\TLSCommon\Tests\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Exception\TLSException;

final class TLSExceptionTest extends TestCase
{
    public function testInstanceOfException()
    {
        $exception = new TLSException();
        $this->assertInstanceOf(Exception::class, $exception);
    }

    public function testConstructor_withDefaultParams()
    {
        $exception = new TLSException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructor_withCustomParams()
    {
        $message = 'Test exception message';
        $code = 42;
        $previous = new Exception('Previous exception');
        
        $exception = new TLSException($message, $code, $previous);
        
        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
