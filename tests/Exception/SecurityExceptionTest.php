<?php

namespace Tourze\TLSCommon\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use Tourze\TLSCommon\Exception\SecurityException;
use Tourze\TLSCommon\Exception\TLSException;

/**
 * @internal
 */
#[CoversClass(SecurityException::class)]
final class SecurityExceptionTest extends AbstractExceptionTestCase
{
    public function testInstanceOfTLSException(): void
    {
        $exception = new SecurityException();
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testConstructorWithDefaultParams(): void
    {
        $exception = new SecurityException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructorWithCustomParams(): void
    {
        $message = 'Security error message';
        $code = 2001;
        $previous = new \Exception('Previous exception');

        $exception = new SecurityException($message, $code, $previous);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
