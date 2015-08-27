<?php

namespace Wecamp\FlyingLiqourice\Domain\Game;

use Assert\Assertion;

class FireResult
{
    const MISS = 'MISS';
    const HIT  = 'HIT';
    const SANK = 'SANK';
    const WIN  = 'WIN';

    /**
     * @var string
     */
    private $result;

    /**
     * @var Coords
     */
    private $target;

    /**
     * @var Coords|null
     */
    private $startPoint;

    /**
     * @var Coords|null
     */
    private $endPoint;

    /**
     * @param string $result
     * @param Coords $target
     * @param Coords $startPoint
     * @param Coords $endPoint
     */
    private function __construct($result, Coords $target, Coords $startPoint = null, Coords $endPoint = null)
    {
        Assertion::choice($result, [static::HIT, static::MISS, static::SANK, static::WIN]);

        if (in_array($result, [static::SANK, static::WIN])) {
            Assertion::notNull($startPoint);
            Assertion::notNull($endPoint);
        }

        $this->result     = $result;
        $this->startPoint = $startPoint;
        $this->endPoint   = $endPoint;
        $this->target     = $target;
    }

    /**
     * @param Coords $target
     *
     * @return static
     */
    public static function miss(Coords $target)
    {
        return new static(static::MISS, $target);
    }

    /**
     * @param Coords $target
     *
     * @return static
     */
    public static function hit(Coords $target)
    {
        return new static(static::HIT, $target);
    }

    /**
     * @param Coords $target
     * @param Coords $startPoint
     * @param Coords $endPoint
     *
     * @return static
     */
    public static function sank(Coords $target, Coords $startPoint, Coords $endPoint)
    {
        return new static(static::SANK, $target, $startPoint, $endPoint);
    }

    /**
     * @param Coords $target
     * @param Coords $startPoint
     * @param Coords $endPoint
     *
     * @return static
     */
    public static function win(Coords $target, Coords $startPoint, Coords $endPoint)
    {
        return new static(static::WIN, $target, $startPoint, $endPoint);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (in_array($this->result, [static::SANK, static::WIN])) {
            return $this->result . ' ' . (string) $this->target . ' ' . ((string) $this->startPoint) . ' ' . ((string) $this->endPoint);
        }

        return $this->result;
    }
}
