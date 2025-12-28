<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day8;

use Ewald\AdventOfCode2025\Day8\Day8Part2;
use Ewald\AdventOfCode2025\Day8\Point;
use Ewald\AdventOfCode2025\Day8\Vector;
use PHPUnit\Framework\TestCase;

class Day8Part2Test extends TestCase
{
    public Day8Part2 $instance;
    public array $example = [];

    #[\Override]
    public function setUp(): void
    {
        $example = <<<EOS
        162,817,812
        57,618,57
        906,360,560
        592,479,940
        352,342,300
        466,668,158
        542,29,236
        431,825,988
        739,650,466
        52,470,668
        216,146,977
        819,987,18
        117,168,530
        805,96,715
        346,949,466
        970,615,88
        941,993,340
        862,61,35
        984,92,344
        425,690,689
        EOS;
        $this->example = explode(PHP_EOL, $example);
        $this->instance = new Day8Part2();
    }

    public function testLoadPoints(): void
    {
        $points = $this->instance->loadPoints($this->example);
        $this->assertCount(20, $points);
        $this->assertEquals('(162, 817, 812)', (string) $points[0]);
    }

    public function testGetClosestPairs(): void
    {
        $points = $this->instance->loadPoints($this->example);
        $pairs = $this->instance->getClosestPairs($points, 10);
        $this->assertCount(10, $pairs);
        $expected = [
            [Point::fromString('162,817,812'), Point::fromString('425,690,689'), 316.90219311326956],
            [Point::fromString('162,817,812'), Point::fromString('431,825,988'), 321.560258738545],
            [Point::fromString('906,360,560'), Point::fromString('805,96,715'), 322.36935338211043],
            [Point::fromString('431,825,988'), Point::fromString('425,690,689'), 328.11888089532425],
            [Point::fromString('862,61,35'), Point::fromString('984,92,344'), 333.6555109690233],
            [Point::fromString('52,470,668'), Point::fromString('117,168,530'), 338.33858780813046],
            [Point::fromString('819,987,18'), Point::fromString('941,993,340'), 344.3893145845266],
            [Point::fromString('906,360,560'), Point::fromString('739,650,466'), 347.59890678769403],
            [Point::fromString('346,949,466'), Point::fromString('425,690,689'), 350.786259708102],
            [Point::fromString('906,360,560'), Point::fromString('984,92,344'), 352.936254867646],
        ];
        for ($i = 0; $i < 10; $i++) {
            list($a, $b, $distance) = $expected[$i];
            $this->assertEquals($a, $pairs[$i]->p);
            $this->assertEquals($b, $pairs[$i]->q);
            $this->assertEquals($distance, sqrt($pairs[$i]->distance));
        }
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

    public function testGetLastVector(): void
    {
        $points = $this->instance->loadPoints($this->example);
        $pairs = $this->instance->getClosestPairs($points, 1000);
        $vector = $this->instance->getLastVector($pairs, $points);
        $this->assertEquals(
            new Vector(new Point(216, 146, 977), new Point(117, 168, 530)),
            $vector,
            $this->instance->getLog(),
        );
    }

    public function testGetSolution(): void
    {
        $points = $this->instance->loadPoints($this->example);
        $pairs = $this->instance->getClosestPairs($points, 1000);
        $circuits = $this->instance->getLastVector($pairs, $points);
        $solution = $this->instance->getSolution($circuits);
        $this->assertEquals(25272, $solution, $this->instance->getLog());
    }

    public function testSolveWithExample(): void
    {
        $expectedOutput = 25272;
        $instance = new Day8Part2();
        $instance->maxPairs = 1000;
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
