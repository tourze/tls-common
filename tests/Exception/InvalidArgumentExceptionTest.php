<?php

namespace Tourze\TLSCommon\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use Tourze\TLSCommon\Exception\InvalidArgumentException;
use Tourze\TLSCommon\Exception\TLSException;

/**
 * @internal
 */
#[CoversClass(InvalidArgumentException::class)]
final class InvalidArgumentExceptionTest extends AbstractExceptionTestCase
{
    public function testInstanceOfTLSException(): void
    {
        $exception = new InvalidArgumentException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testInstanceOfException(): void
    {
        $exception = new InvalidArgumentException();
        $this->assertInstanceOf(\Exception::class, $exception);
    }

    public function testConstructorWithDefaultParams(): void
    {
        $exception = new InvalidArgumentException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructorWithCustomParams(): void
    {
        $message = 'Invalid argument provided';
        $code = 400;
        $previous = new \Exception('Previous exception');

        $exception = new InvalidArgumentException($message, $code, $previous);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
