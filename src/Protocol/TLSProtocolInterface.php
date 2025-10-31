<?php

declare(strict_types=1);

namespace Tourze\TLSCommon\Protocol;

/**
 * TLS协议接口
 *
 * 这个接口定义了TLS协议中的基本方法
 */
interface TLSProtocolInterface
{
    /**
     * 获取协议名称
     */
    public function getName(): string;

    /**
     * 获取协议版本
     */
    public function getVersion(): int;

    /**
     * 处理收到的数据
     */
    public function process(string $data): string;

    /**
     * 检查连接是否已建立
     */
    public function isEstablished(): bool;

    /**
     * 获取连接状态
     */
    public function getState(): string;

    /**
     * 关闭连接
     */
    public function close(): void;
}
