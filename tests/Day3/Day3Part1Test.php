<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day3;

use Ewald\AdventOfCode2025\Day3\Day3Part1;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day3Part1Test extends TestCase
{
    public function testSolveWithExample(): void
    {
        $input = [
            '987654321111111',
            '811111111111119',
            '234234234234278',
            '818181911112111',
        ];
        $expectedOutput = 357;
        $day3a = new Day3Part1();
        $this->assertSame($expectedOutput, $day3a->solve($input), $day3a->getLog());
    }

    #[DataProvider('provideInputOutput')]
    public function testGetHighestJoltage(string $input, int $expectedJoltage): void
    {
        $day3a = new Day3Part1();
        $this->assertSame($expectedJoltage, $day3a->getHighestJoltage($input), $day3a->getLog());
    }

    public static function provideInputOutput(): iterable
    {
        yield ['987654321111111', 98];
        yield ['811111111111119', 89];
        yield ['234234234234278', 78];
        yield ['818181911112111', 92];
    }
}
