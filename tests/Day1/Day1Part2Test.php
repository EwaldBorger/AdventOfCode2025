<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day1;

use Ewald\AdventOfCode2025\Day1\Day1Part2;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day1Part2Test extends TestCase
{
    #[DataProvider('provideRotations')]
    public function testGetRotationsFromString(string $input, int $rotation): void
    {
        $this->assertSame((new Day1Part2())->getRotationsFromString($input), $rotation);
    }

    #[DataProvider('provideBasic')]
    public function testProcessLines(array $input, int $out): void
    {
        $day1b = new Day1Part2();
        $this->assertSame($out, $day1b->solve($input), $day1b->getLog());
    }

    /**
     * @return iterable<string: array{0: string, 1: int}>
     */
    public static function provideRotations(): iterable
    {
        yield 'L68' => ['L68', -68];
        yield 'R28' => ['R28', 28];
        yield 'L293993' => ['L293993', -293993];
        yield 'R9393004' => ['R9393004', 9393004];
        yield 'R0' => ['R0', 0];
        yield 'L0' => ['L0', 0];
    }

    /**
     * @return iterable<string: array{0: string[], 1: int}>
     */
    public static function provideBasic(): iterable
    {
        yield '10 - in one pass to the left' => [['L1000'], 10];
        yield '10 - in one pass to the right' => [['R1000'], 10];
        yield '1 - basic pass to the left' => [['L75', 'R20'], 1];
        yield '1 - basic pass to the right' => [['R75', 'L20'], 1];
        yield '1 - left ending on zero LR' => [['L50', 'R50'], 1];
        yield '1 - left ending on zero LL' => [['L50', 'L50'], 1];
        yield '1 - right ending on zero RR' => [['R50', 'R50'], 1];
        yield '1 - right ending on zero RL' => [['R50', 'L50'], 1];

        yield '2 - basic pass to the left' => [['L200'], 2];
        yield '2 - basic pass to the right' => [['R200'], 2];
        yield '2 - extra pass left landing on zero LL' => [['L150', 'L50'], 2];
        yield '2 - extra pass left landing on zero LR' => [['L150', 'R50'], 2];
        yield '2 - extra pass right landing on zero RL' => [['R150', 'L50'], 2];
        yield '2 - extra pass right landing on zero RR' => [['R150', 'R50'], 2];

        yield 'test example' => [['L68', 'L30', 'R48', 'L5', 'R60', 'L55', 'L1', 'L99', 'R14', 'L82'], 6];
    }
}
