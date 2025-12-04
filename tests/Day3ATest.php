<?php declare(strict_types=1);


use Ewald\AdventOfCode2025\Day3A;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day3ATest extends TestCase
{

    public function testSolveWithExample(): void
    {
        $input = [
            "987654321111111",
            "811111111111119",
            "234234234234278",
            "818181911112111",
        ];
        $expectedOutput = 357;
        $day3a = new Day3A();
        $this->assertSame($expectedOutput, $day3a->solve($input), $day3a->getLog());
    }

    #[DataProvider("provideInputOutput")]
    public function testGetHighestJoltage(string $input, int $expectedJoltage): void
    {
        $day3a = new Day3A();
        $this->assertSame($expectedJoltage, $day3a->getHighestJoltage($input), $day3a->getLog());
    }

    public static function provideInputOutput(): iterable
    {
        yield ["987654321111111", 98];
        yield ["811111111111119", 89];
        yield ["234234234234278", 78];
        yield ["818181911112111", 92];
    }

}
