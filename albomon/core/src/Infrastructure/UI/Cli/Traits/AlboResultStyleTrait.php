<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Traits;

trait AlboResultStyleTrait
{
    protected function formatContentUpdatedAt(\DateTime $contenteDateTime): string
    {
        $dateNow = new \DateTime('now');

        $diff = $dateNow->diff($contenteDateTime)->days;

        return $contenteDateTime->format('Y-m-d').'  -'.$diff.' gg.';
    }
}
