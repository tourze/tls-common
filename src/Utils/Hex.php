<?php

declare(strict_types=1);

namespace Tourze\TLSCommon\Utils;

use Tourze\TLSCommon\Exception\InvalidArgumentException;

/**
 * 十六进制数据转换工具
 */
class Hex
{
    /**
     * 将二进制数据转换为十六进制字符串
     *
     * @param string $data      要转换的二进制数据
     * @param bool   $uppercase 是否使用大写字母表示十六进制
     *
     * @return string 十六进制字符串
     */
    public static function encode(string $data, bool $uppercase = false): string
    {
        $result = bin2hex($data);

        return $uppercase ? strtoupper($result) : $result;
    }

    /**
     * 将十六进制字符串转换为二进制数据
     *
     * @param string $hex 要转换的十六进制字符串
     *
     * @return string 二进制数据
     *
     * @throws InvalidArgumentException 如果输入不是有效的十六进制字符串
     */
    public static function decode(string $hex): string
    {
        // 移除可能的空格
        $hex = str_replace(' ', '', $hex);

        // 检查是否为有效的十六进制字符串
        if (!ctype_xdigit($hex)) {
            throw new InvalidArgumentException('输入不是有效的十六进制字符串');
        }

        // 如果长度为奇数，前面补0
        if (0 !== strlen($hex) % 2) {
            $hex = '0' . $hex;
        }

        $result = hex2bin($hex);
        if (false === $result) {
            throw new InvalidArgumentException('十六进制字符串解码失败');
        }

        return $result;
    }

    /**
     * 将二进制数据转换为带格式的十六进制字符串
     *
     * @param string $data      要转换的二进制数据
     * @param string $separator 字节之间的分隔符
     * @param bool   $uppercase 是否使用大写字母表示十六进制
     *
     * @return string 格式化的十六进制字符串
     */
    public static function formatHex(string $data, string $separator = ' ', bool $uppercase = false): string
    {
        if ('' === $data) {
            return '';
        }

        $hex = self::encode($data, $uppercase);
        $result = '';

        for ($i = 0; $i < strlen($hex); $i += 2) {
            $result .= substr($hex, $i, 2) . $separator;
        }

        return rtrim($result, $separator);
    }

    /**
     * 以十六进制转储格式显示二进制数据
     *
     * @param string $data         要显示的二进制数据
     * @param bool   $showAscii    是否显示ASCII表示
     * @param int    $bytesPerLine 每行显示的字节数
     *
     * @return string 十六进制转储字符串
     */
    public static function hexDump(string $data, bool $showAscii = true, int $bytesPerLine = 16): string
    {
        if ('' === $data) {
            return '(空)';
        }

        $result = '';
        $dataLength = strlen($data);

        for ($i = 0; $i < $dataLength; $i += $bytesPerLine) {
            $lineData = substr($data, $i, $bytesPerLine);
            $result .= self::formatHexDumpLine($i, $lineData, $showAscii, $bytesPerLine);
        }

        return $result;
    }

    /**
     * 格式化十六进制转储的单行
     *
     * @param int    $offset       当前行的偏移量
     * @param string $lineData     当前行的数据
     * @param bool   $showAscii    是否显示ASCII表示
     * @param int    $bytesPerLine 每行字节数
     *
     * @return string 格式化的行
     */
    private static function formatHexDumpLine(int $offset, string $lineData, bool $showAscii, int $bytesPerLine): string
    {
        $line = sprintf('%08X  ', $offset);
        $line .= self::formatHexDumpHexPart($lineData, $bytesPerLine);

        if ($showAscii) {
            $line .= self::formatHexDumpAsciiPart($lineData, $bytesPerLine);
        }

        return $line . "\n";
    }

    /**
     * 格式化十六进制部分
     *
     * @param string $lineData     行数据
     * @param int    $bytesPerLine 每行字节数
     *
     * @return string 格式化的十六进制部分
     */
    private static function formatHexDumpHexPart(string $lineData, int $bytesPerLine): string
    {
        $lineLength = strlen($lineData);
        $hexPart = '';

        for ($j = 0; $j < $lineLength; ++$j) {
            $hexPart .= sprintf('%02X ', ord($lineData[$j]));

            if ($j === $bytesPerLine / 2 - 1) {
                $hexPart .= ' ';
            }
        }

        return self::padHexPart($hexPart, $lineLength, $bytesPerLine);
    }

    /**
     * 为十六进制部分添加填充
     *
     * @param string $hexPart      当前十六进制部分
     * @param int    $lineLength   当前行数据长度
     * @param int    $bytesPerLine 每行字节数
     *
     * @return string 填充后的十六进制部分
     */
    private static function padHexPart(string $hexPart, int $lineLength, int $bytesPerLine): string
    {
        $padding = $bytesPerLine - $lineLength;

        if ($padding > 0) {
            $hexPart .= str_repeat('   ', $padding);

            if ($lineLength <= $bytesPerLine / 2) {
                $hexPart .= ' ';
            }
        }

        return $hexPart;
    }

    /**
     * 格式化ASCII部分
     *
     * @param string $lineData     行数据
     * @param int    $bytesPerLine 每行字节数
     *
     * @return string 格式化的ASCII部分
     */
    private static function formatHexDumpAsciiPart(string $lineData, int $bytesPerLine): string
    {
        $lineLength = strlen($lineData);
        $asciiPart = ' |';

        for ($j = 0; $j < $lineLength; ++$j) {
            $asciiPart .= self::formatAsciiChar($lineData[$j]);
        }

        $padding = $bytesPerLine - $lineLength;
        if ($padding > 0) {
            $asciiPart .= str_repeat(' ', $padding);
        }

        return $asciiPart . '|';
    }

    /**
     * 格式化单个ASCII字符
     *
     * @param string $char 要格式化的字符
     *
     * @return string 格式化后的字符
     */
    private static function formatAsciiChar(string $char): string
    {
        $ord = ord($char);

        return ($ord >= 32 && $ord <= 126) ? $char : '.';
    }
}
