<?php declare(strict_types=1);

namespace Albomon\Catalog\Application\Model;

use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

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
        if (false === filter_var($rssFeedUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Expected a rss feed url value to be a valid URL');
        }

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
