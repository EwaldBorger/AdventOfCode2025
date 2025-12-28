<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day8;

use Ewald\AdventOfCode2025\Day8\Point;
use Ewald\AdventOfCode2025\Day8\Vector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VectorTest extends TestCase
{
    #[DataProvider('pointsDistancesProvider')]
    public function testConstruct(Point $p, Point $q, float $distance): void
    {
        $v = new Vector($p, $q);
        $this->assertEquals($distance, $v->distance);
    }

    public static function pointsDistancesProvider(): iterable
    {
        yield [Point::fromString('162,817,812'), Point::fromString('425,690,689'), 316.90219311326956];
        yield [Point::fromString('162,817,812'), Point::fromString('431,825,988'), 321.560258738545];
        yield [Point::fromString('906,360,560'), Point::fromString('805,96,715'), 322.36935338211043];
        yield [Point::fromString('431,825,988'), Point::fromString('425,690,689'), 328.11888089532425];
        yield [Point::fromString('862,61,35'), Point::fromString('984,92,344'), 333.6555109690233];
        yield [Point::fromString('52,470,668'), Point::fromString('117,168,530'), 338.33858780813046];
        yield [Point::fromString('819,987,18'), Point::fromString('941,993,340'), 344.3893145845266];
        yield [Point::fromString('906,360,560'), Point::fromString('739,650,466'), 347.59890678769403];
        yield [Point::fromString('346,949,466'), Point::fromString('425,690,689'), 350.786259708102];
        yield [Point::fromString('906,360,560'), Point::fromString('984,92,344'), 352.936254867646];
    }
}
