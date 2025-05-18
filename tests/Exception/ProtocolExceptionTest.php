<?php

namespace Tourze\TLSCommon\Tests\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCommon\Exception\ProtocolException;
use Tourze\TLSCommon\Exception\TLSException;

final class ProtocolExceptionTest extends TestCase
{
    public function testInstanceOfTLSException()
    {
        $exception = new ProtocolException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testConstructor_withDefaultParams()
    {
        $exception = new ProtocolException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructor_withCustomParams()
    {
        $message = 'Protocol error message';
        $code = 1001;
        $previous = new Exception('Previous exception');
        
        $exception = new ProtocolException($message, $code, $previous);
        
        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
