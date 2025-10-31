<?php

declare(strict_types=1);

namespace Tourze\TLSCommon\Utils;

use Tourze\TLSCommon\Exception\InvalidArgumentException;

/**
 * Base64编解码工具
 */
class Base64
{
    /**
     * 将二进制数据编码为Base64字符串
     *
     * @param string $data    要编码的二进制数据
     * @param bool   $urlSafe 是否使用URL安全的Base64编码
     *
     * @return string Base64编码的字符串
     */
    public static function encode(string $data, bool $urlSafe = false): string
    {
        $result = base64_encode($data);

        if ($urlSafe) {
            $result = str_replace(['+', '/', '='], ['-', '_', ''], $result);
        }

        return $result;
    }

    /**
     * 将Base64字符串解码为二进制数据
     *
     * @param string $base64  要解码的Base64字符串
     * @param bool   $urlSafe 是否使用URL安全的Base64编码
     *
     * @return string 解码后的二进制数据
     *
     * @throws InvalidArgumentException 如果输入不是有效的Base64字符串
     */
    public static function decode(string $base64, bool $urlSafe = false): string
    {
        // 移除可能的空格和换行符
        $base64 = trim($base64);

        if ($urlSafe) {
            // 恢复标准Base64字符
            $base64 = str_replace(['-', '_'], ['+', '/'], $base64);

            // 添加可能缺少的填充字符
            $padLength = strlen($base64) % 4;
            if ($padLength > 0) {
                $base64 .= str_repeat('=', 4 - $padLength);
            }
        }

        $result = base64_decode($base64, true);

        if (false === $result) {
            throw new InvalidArgumentException('输入不是有效的Base64字符串');
        }

        return $result;
    }

    /**
     * 将二进制数据编码为PEM格式
     *
     * @param string $data 要编码的二进制数据
     * @param string $type PEM类型标识，如CERTIFICATE, PUBLIC KEY等
     *
     * @return string PEM格式的字符串
     */
    public static function toPEM(string $data, string $type): string
    {
        $base64 = chunk_split(base64_encode($data), 64);

        return "-----BEGIN {$type}-----\n{$base64}-----END {$type}-----\n";
    }

    /**
     * 从PEM格式中提取二进制数据
     *
     * @param string $pem PEM格式的字符串
     *
     * @return string 提取的二进制数据
     *
     * @throws InvalidArgumentException 如果输入不是有效的PEM格式
     */
    public static function fromPEM(string $pem): string
    {
        // 移除可能的空格和换行符
        $pem = trim($pem);

        // 提取Base64部分
        $pattern = '/-----BEGIN [^-]+-----\s*(.+?)\s*-----END [^-]+-----/s';
        if (0 === preg_match($pattern, $pem, $matches)) {
            throw new InvalidArgumentException('输入不是有效的PEM格式');
        }

        // 移除所有空白字符
        $base64 = preg_replace('/\s+/', '', $matches[1]);

        if (null === $base64) {
            throw new InvalidArgumentException('无法处理PEM格式中的Base64数据');
        }

        $result = base64_decode($base64, true);

        if (false === $result) {
            throw new InvalidArgumentException('PEM格式中的Base64数据无效');
        }

        return $result;
    }
}
