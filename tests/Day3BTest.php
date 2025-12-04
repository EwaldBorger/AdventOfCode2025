<?php declare(strict_types=1);


use Ewald\AdventOfCode2025\Day3A;
use Ewald\AdventOfCode2025\Day3B;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day3BTest extends TestCase
{

    public function testSolveWithExample(): void
    {
        $input = [
            "987654321111111",
            "811111111111119",
            "234234234234278",
            "818181911112111",
        ];
        $expectedOutput = 3121910778619;
        $day3b = new Day3B();
        $this->assertSame($expectedOutput, $day3b->solve($input), $day3b->getLog());
    }

    #[DataProvider("provideInputOutput")]
    public function testGetHighestJoltage(string $input, int $expectedJoltage): void
    {
        $day3b = new Day3B();
        $this->assertSame($expectedJoltage, $day3b->getHighestJoltage($input), $day3b->getLog());
    }

    public static function provideInputOutput(): iterable
    {
        yield ["987654321111111", 987654321111];
        yield ["811111111111119", 811111111119];
        yield ["234234234234278", 434234234278];
        yield ["818181911112111", 888911112111];
    }

}
