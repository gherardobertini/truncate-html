# truncate-html

A lightweight PHP library to safely truncate HTML strings **without breaking tags or cutting words**.

## 📦 Installation

Install via Composer:

```bash
composer require gherardobertini/truncate-html
```

## 🚀 Usage

```php
use Gherardobertini\TruncateHtml\TruncateHtml;

$html = "<p>Hello this is a test</p>";

echo TruncateHtml::truncate($html, 0, 10);
// Output: <p>Hello this</p>

echo TruncateHtml::truncate($html, 10);
// Output: <p>is a test</p>
```

### 🔧 Method Signature

```php
public static function truncate(string $html, int $start = 0, ?int $length = null): string
```

- `$start` — The character offset where to begin (default is `0`).
- `$length` — The number of characters to include (optional). If `null`, returns everything from `$start` to the end.
- Words are never cut in half.
- Open tags are properly closed to maintain valid HTML.

## ✅ Example

```php
$html = "<p>Hello this is a test</p>";

TruncateHtml::truncate($html, 0, 10);  // <p>Hello this</p>
TruncateHtml::truncate($html, 10);     // <p>is a test</p>
```

## 🧪 Running Tests

Install dependencies and run PHPUnit:

```bash
composer install
vendor/bin/phpunit
```

## 📄 License

MIT License – see the [LICENSE](LICENSE) file for details.
