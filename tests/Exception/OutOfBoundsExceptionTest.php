<?php

namespace Tourze\TLSCommon\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use Tourze\TLSCommon\Exception\OutOfBoundsException;
use Tourze\TLSCommon\Exception\TLSException;

/**
 * @internal
 */
#[CoversClass(OutOfBoundsException::class)]
final class OutOfBoundsExceptionTest extends AbstractExceptionTestCase
{
    public function testInstanceOfTLSException(): void
    {
        $exception = new OutOfBoundsException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testInstanceOfException(): void
    {
        $exception = new OutOfBoundsException();
        $this->assertInstanceOf(\Exception::class, $exception);
    }

    public function testConstructorWithDefaultParams(): void
    {
        $exception = new OutOfBoundsException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructorWithCustomParams(): void
    {
        $message = 'Index out of bounds';
        $code = 404;
        $previous = new \Exception('Previous exception');

        $exception = new OutOfBoundsException($message, $code, $previous);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
