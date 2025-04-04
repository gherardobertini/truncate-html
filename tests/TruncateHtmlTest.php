<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Gherardobertini\TruncateHtml\TruncateHtml;

class TruncateHtmlTest extends TestCase
{
    public function testTruncateStartAndLength(): void
    {
        $html = "<p>Hello This is a test</p>";
        $result = TruncateHtml::truncate($html, 0, 10);
        $this->assertEquals("<p>Hello This</p>", $result);
    }

    public function testTruncateStartOnly(): void
    {
        $html = "<p>Hello This is a test</p>";
        $result = TruncateHtml::truncate($html, 10);
        $this->assertEquals("<p>is a test</p>", $result);
    }

    #[DataProvider('truncateDataProvider')]
    public function testTruncate($str, $start, $length, $expected): void
    {
        $result = TruncateHtml::truncate($str, $start, $length);
        $this->assertEquals($expected, $result);
    }

    public static function truncateDataProvider(): array
    {
        return [
            [
                "<p>Hello This is a test</p>",
                0,
                10,
                "<p>Hello This</p>"
            ],
            [
                "<p>Hello This is a test</p>",
                10,
                null,
                "<p>is a test</p>"
            ],
            [
                "<p>Hello This is a test</p>",
                0,
                null,
                "<p>Hello This is a test</p>"
            ],
            [
                "<div><span>Hello</span> <strong>This</strong> is a test</div>",
                0,
                10,
                "<div><span>Hello</span> <strong>This</strong></div>"
            ],
            [
                "<div><span>Hello</span> <strong>This</strong> is a test</div>",
                10,
                null,
                "<div>is a test</div>"
            ],
            [
                "<div><span>Hello</span> <strong>This</strong> is a test</div>",
                0,
                5,
                "<div><span>Hello</span></div>"
            ],
            [
                "<div><span>Hello</span> <strong>This</strong> is a test</div>",
                5,
                5,
                "<div><strong>This</strong></div>"
            ],
            [
                "<div><span>Hello</span> <strong>This</strong> is a test</div>",
                0,
                0,
                ""
            ],
            [
                "<div><span>Hello</span> <strong>This</strong> is a test</div>",
                0,
                100,
                "<div><span>Hello</span> <strong>This</strong> is a test</div>"
            ],
            [
                "<div><span>Hello</span> <strong>This</strong> is a test</div>",
                100,
                null,
                ""
            ],
        ];
    }

    public function testTruncateCountSingleWhiteSpaceBetweenWords(): void
    {
        $html = "<p>12345 12345 12345</p>";
        $result = TruncateHtml::truncate($html, 0, 10);
        $this->assertEquals("<p>12345</p>", $result);
    }

    public function testTruncateCountSingleWhiteSpaceBetweenWords2(): void
    {
        $html = "<p>12345 12345 12345</p>";
        $result = TruncateHtml::truncate($html, 0, 11);
        $this->assertEquals("<p>12345 12345</p>", $result);
    }
}
