<?php

namespace Tourze\TLSCommon\Tests\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Exception\OutOfBoundsException;
use Tourze\TLSCommon\Exception\TLSException;

final class OutOfBoundsExceptionTest extends TestCase
{
    public function testInstanceOfTLSException()
    {
        $exception = new OutOfBoundsException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testInstanceOfException()
    {
        $exception = new OutOfBoundsException();
        $this->assertInstanceOf(Exception::class, $exception);
    }

    public function testConstructor_withDefaultParams()
    {
        $exception = new OutOfBoundsException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructor_withCustomParams()
    {
        $message = 'Index out of bounds';
        $code = 404;
        $previous = new Exception('Previous exception');
        
        $exception = new OutOfBoundsException($message, $code, $previous);
        
        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}