<?php

/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @author      Karl DeBisschop <kdebisschop@gmail.com>
 * @copyright   Copyright (c) Wizacha
 * @license     MIT
 */

declare(strict_types=1);

namespace Wizaplace\Etl\Transformers;

use Wizaplace\Etl\Row;

/**
 * Formats a Unix time (seconds since 1970-01-01).
 */
class FormatUnixTime extends Transformer
{
    /**
     * Transformer columns.
     *
     * @var string[]
     */
    protected $columns = [];

    /**
     * Format for rendered date, as per DateTime::format() [default: 'Ymd'].
     *
     * @var string
     */
    protected $format = 'Ymd';

    /**
     * Timezone of rendered date [default: current PHP default value].
     *
     * @var string
     */
    protected $timezone;

    /**
     * Properties that can be set via the options method.
     *
     * @var string[]
     */
    protected $availableOptions = ['columns', 'format', 'timezone'];

    /**
     * Sets default timezone.
     */
    public function __construct()
    {
        $this->timezone = date_default_timezone_get();
    }

    public function transform(Row $row): void
    {
        $row->transform($this->columns, function ($column): string {
            return (new \DateTime())->setTimezone(new \DateTimeZone($this->timezone))
                ->setTimestamp((int) $column)->format($this->format);
        });
    }
}
