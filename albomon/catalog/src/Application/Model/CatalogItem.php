<?php declare(strict_types=1);

namespace Albomon\Catalog\Application\Model;

use Webmozart\Assert\Assert;

class CatalogItem
{
    private function __construct(
        private string $identity,
        private string $name,
        private string $rssFeedUrl,
    ) {
    }

    public static function with(string $identity, string $name, string $rssFeedUrl): self
    {
        Assert::stringNotEmpty($identity, 'Catalog item must have an identifier');
        Assert::uuid($identity, 'Catalog item identity should be an uuid. Got %s');
        Assert::stringNotEmpty($name, 'Catalog item must have a name');
        Assert::stringNotEmpty($rssFeedUrl, 'Catalog item must have an rss feed url');

        return new self($identity, $name, $rssFeedUrl);
    }

    public function identity(): string
    {
        return $this->identity;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function rssFeedUrl(): string
    {
        return $this->rssFeedUrl;
    }
}
