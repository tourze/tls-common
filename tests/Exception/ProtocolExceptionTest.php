<?php

namespace Tourze\TLSCommon\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use Tourze\TLSCommon\Exception\ProtocolException;
use Tourze\TLSCommon\Exception\TLSException;

/**
 * @internal
 */
#[CoversClass(ProtocolException::class)]
final class ProtocolExceptionTest extends AbstractExceptionTestCase
{
    public function testInstanceOfTLSException(): void
    {
        $exception = new ProtocolException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testConstructorWithDefaultParams(): void
    {
        $exception = new ProtocolException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructorWithCustomParams(): void
    {
        $message = 'Protocol error message';
        $code = 1001;
        $previous = new \Exception('Previous exception');

        $exception = new ProtocolException($message, $code, $previous);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
