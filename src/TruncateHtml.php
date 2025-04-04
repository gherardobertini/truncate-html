<?php

namespace Gherardobertini\TruncateHtml;

use DOMDocument;
use DOMElement;
use DOMText;

class TruncateHtml
{
    public static function truncate(string $str, int $start = 0, ?int $length = null): string
    {
        if ($length === 0) return '';

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $str, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $output = '';
        $charCount = 0;
        $copiedCount = 0;
        $openTags = [];

        $walker = function($node) use (&$walker, &$output, &$charCount, &$copiedCount, $start, $length, &$openTags) {
            if ($node instanceof DOMText) {
                $text = $node->nodeValue;
                $words = preg_split('/(\s+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

                foreach ($words as $word) {
                    $plain = preg_replace('/\s+/', '', $word);
                    $wlen = mb_strlen($plain);

                    if ($charCount + $wlen <= $start) {
                        $charCount += $wlen;
                        continue;
                    }

                    if ($length !== null && $copiedCount + $wlen > $length) break;

                    $output .= htmlspecialchars($word, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                    $charCount += $wlen;
                    $copiedCount += $wlen;
                }
            } elseif ($node instanceof DOMElement) {
                $output .= "<{$node->tagName}";
                foreach ($node->attributes as $attr) {
                    $output .= " {$attr->nodeName}=\"".htmlspecialchars($attr->nodeValue)."\"";
                }
                $output .= ">";

                array_unshift($openTags, $node->tagName);

                foreach ($node->childNodes as $child) {
                    $walker($child);
                    if ($length !== null && $copiedCount >= $length) break;
                }

                $tag = array_shift($openTags);
                $output = rtrim($output); // Removes white spaces before closing tag
                $output .= "</$tag>";
            }
        };

        foreach ($dom->childNodes as $node) {
            $walker($node);
            if ($length !== null && $copiedCount >= $length) break;
        }

        // Removes empty tags
        $output = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/', '', $output);

        // Removes empty tags with attributes
        $output = preg_replace('/<(\w+)[^>]*>\s*<\/\1>/', '', $output);

        return $output;
    }
}
