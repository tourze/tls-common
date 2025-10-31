<?php

namespace Tourze\TLSCommon\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use Tourze\TLSCommon\Exception\InvalidArgumentException;
use Tourze\TLSCommon\Exception\TLSException;

/**
 * @internal
 */
#[CoversClass(TLSException::class)]
final class TLSExceptionTest extends AbstractExceptionTestCase
{
    public function testInstanceOfException(): void
    {
        // 使用具体子类测试抽象基类的功能
        $exception = new InvalidArgumentException();
        $this->assertInstanceOf(\Exception::class, $exception);
        $this->assertInstanceOf(TLSException::class, $exception);
    }

    public function testConstructorWithDefaultParams(): void
    {
        // 使用具体子类测试抽象基类的构造函数
        $exception = new InvalidArgumentException();
        $this->assertSame('', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function testConstructorWithCustomParams(): void
    {
        $message = 'Test exception message';
        $code = 42;
        $previous = new \Exception('Previous exception');

        // 使用具体子类测试抽象基类的构造函数
        $exception = new InvalidArgumentException($message, $code, $previous);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
