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
        $title = null;
        $lines = explode("\n", $this->markdownContent);

        foreach ($lines as $contentLine) {
            if ($this->isSeparatorLine($contentLine) || $this->isCommentLine($contentLine)) {
                continue;
            }
            if (str_starts_with(trim($contentLine), 'title:')) {
                $title = substr($contentLine, 6, \strlen($contentLine));
            } else {
                throw new \RuntimeException('Markdown conversion error: unable to find a title');
            }
            break;
        }

        return trim($title);
    }

    public function getOriginalAlboUrl(): string
    {
        $originalAlboUrl = '';
        $lines = explode("\n", $this->markdownContent);
        foreach ($lines as $contentLine) {
            if ($this->isSeparatorLine($contentLine) || $this->isCommentLine($contentLine)) {
                continue;
            }
            if (str_starts_with(trim($contentLine), 'original:')) {
                $originalAlboUrl = substr($contentLine, 9, \strlen($contentLine));
                break;
            }
        }
        if ('' === $originalAlboUrl) {
            throw new \RuntimeException('Markdown conversion error: unable to find a original albo url');
        }

        return trim($originalAlboUrl);
    }

    public function getRssFeedUrl(): string
    {
        $rssFeedUrl = '';
        $lines = explode("\n", $this->markdownContent);

        foreach ($lines as $contentLine) {
            if ($this->isSeparatorLine($contentLine) || $this->isCommentLine($contentLine)) {
                continue;
            }
            if (str_starts_with(trim($contentLine), 'rss:')) {
                $rssFeedUrl = substr($contentLine, 4, \strlen($contentLine));
                break;
            }
        }
        if ('' === $rssFeedUrl) {
            throw new \RuntimeException('Markdown conversion error: unable to find an rss feed url.');
        }

        return trim($rssFeedUrl);
    }

    public function asArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'original' => $this->getOriginalAlboUrl(),
            'rss' => $this->getRssFeedUrl(),
        ];
    }

    private function isCommentLine(string $line): bool
    {
        return str_starts_with(trim($line), '#');
    }

    private function isSeparatorLine(string $line): bool
    {
        return '---' === trim($line);
    }
}
