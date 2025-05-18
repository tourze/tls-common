<?php

namespace Tourze\TLSCommon\Utils;

use InvalidArgumentException;

/**
 * 十六进制数据转换工具
 */
class Hex
{
    /**
     * 将二进制数据转换为十六进制字符串
     *
     * @param string $data 要转换的二进制数据
     * @param bool $uppercase 是否使用大写字母表示十六进制
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
     * @return string 二进制数据
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
        if (strlen($hex) % 2 !== 0) {
            $hex = '0' . $hex;
        }

        return hex2bin($hex);
    }

    /**
     * 将二进制数据转换为带格式的十六进制字符串
     *
     * @param string $data 要转换的二进制数据
     * @param string $separator 字节之间的分隔符
     * @param bool $uppercase 是否使用大写字母表示十六进制
     * @return string 格式化的十六进制字符串
     */
    public static function formatHex(string $data, string $separator = ' ', bool $uppercase = false): string
    {
        if (empty($data)) {
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
     * @param string $data 要显示的二进制数据
     * @param bool $showAscii 是否显示ASCII表示
     * @param int $bytesPerLine 每行显示的字节数
     * @return string 十六进制转储字符串
     */
    public static function hexDump(string $data, bool $showAscii = true, int $bytesPerLine = 16): string
    {
        if (empty($data)) {
            return '(空)';
        }

        $result = '';
        $dataLength = strlen($data);

        for ($i = 0; $i < $dataLength; $i += $bytesPerLine) {
            // 地址
            $result .= sprintf("%08X  ", $i);

            $lineData = substr($data, $i, $bytesPerLine);
            $lineLength = strlen($lineData);

            // 十六进制部分
            $hexPart = '';
            for ($j = 0; $j < $lineLength; $j++) {
                $hexPart .= sprintf("%02X ", ord($lineData[$j]));

                // 在中间位置添加额外的空格
                if ($j === $bytesPerLine / 2 - 1) {
                    $hexPart .= ' ';
                }
            }

            // 填充空格使ASCII部分对齐
            $padding = $bytesPerLine - $lineLength;
            if ($padding > 0) {
                $hexPart .= str_repeat("   ", $padding);

                // 如果中间位置在填充部分，添加额外的空格
                if ($lineLength <= $bytesPerLine / 2) {
                    $hexPart .= ' ';
                }
            }

            $result .= $hexPart;

            // ASCII部分
            if ($showAscii) {
                $result .= " |";
                for ($j = 0; $j < $lineLength; $j++) {
                    $char = $lineData[$j];
                    $ord = ord($char);

                    // 只显示可打印的ASCII字符
                    if ($ord >= 32 && $ord <= 126) {
                        $result .= $char;
                    } else {
                        $result .= '.';
                    }
                }

                // 填充空格
                if ($padding > 0) {
                    $result .= str_repeat(" ", $padding);
                }

                $result .= "|";
            }

            $result .= "\n";
        }

        return $result;
    }
}
