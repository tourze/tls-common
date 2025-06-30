<?php

namespace Tourze\TLSCommon\Tests\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Exception\InvalidArgumentException;
use Tourze\TLSCommon\Exception\TLSException;

final class InvalidArgumentExceptionTest extends TestCase
{
    public function testInstanceOfTLSException()
    {
        $exception = new InvalidArgumentException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testInstanceOfException()
    {
        $exception = new InvalidArgumentException();
        $this->assertInstanceOf(Exception::class, $exception);
    }

    public function testConstructor_withDefaultParams()
    {
        $exception = new InvalidArgumentException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructor_withCustomParams()
    {
        $message = 'Invalid argument provided';
        $code = 400;
        $previous = new Exception('Previous exception');
        
        $exception = new InvalidArgumentException($message, $code, $previous);
        
        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}