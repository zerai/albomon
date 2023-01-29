<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter;

class MarkdownToCatalogItemConverter
{
    private string $markdownContent;

    public function __construct(string $markdownContent)
    {
        if ('' === $markdownContent) {
            throw new \InvalidArgumentException('Markdown content empty.');
        }
        $this->markdownContent = $markdownContent;
    }

    public static function createFromMarkdownContent(string $markdownContent): self
    {
        return new self($markdownContent);
    }

    public function getTitle(): string
    {
        $lines = explode("\n", $this->markdownContent);

        foreach ($lines as $contentLine) {
            if ('---' === $contentLine || '#' === substr($contentLine, 0, 1)) {
                continue;
            }
            try {
                $x = explode(':', $contentLine);
                [$lineKey, $lineValue] = $x;
                if ('title' === $lineKey) {
                    $title = trim($lineValue);
                }
                return $title;
            } catch (\Exception $exception) {
                throw new \RuntimeException('Markdown conversion error: unable to find a title');
            }
        }
    }

    public function getOriginalAlboUrl(): string
    {
        $lines = explode("\n", $this->markdownContent);

        foreach ($lines as $contentLine) {
            if ('---' === $contentLine) {
                continue;
            }
            $x = explode(':', $contentLine);
            if (3 === \count($x)) {
                [$lineKey, $lineValue1, $lineValue2] = $x;
                if ('original' === $lineKey) {
                    return trim($lineValue1) . ':' . trim($lineValue2);
                }
            } else {
                continue;
            }

            throw new \RuntimeException('Markdown conversion error: unable to find a original albo url');
        }
    }

    public function getRssFeedUrl(): string
    {
        $lines = explode("\n", $this->markdownContent);

        foreach ($lines as $contentLine) {
            if ('---' === $contentLine) {
                continue;
            }
            $x = explode(':', $contentLine);
            if (3 === \count($x)) {
                [$lineKey, $lineValue1, $lineValue2] = $x;
                if ('original' === $lineKey) {
                    continue;
                }
                if ('rss' === $lineKey) {
                    return trim($lineValue1) . ':' . trim($lineValue2);
                }
            } else {
                continue;
            }

            throw new \RuntimeException('Markdown conversion error: unable to find a rss feed url');
        }
    }

    public function asArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'original' => $this->getOriginalAlboUrl(),
            'rss' => $this->getRssFeedUrl(),
        ];
    }
}
