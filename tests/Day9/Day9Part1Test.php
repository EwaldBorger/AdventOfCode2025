<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day9;

use Ewald\AdventOfCode2025\Day9\Day9Part1;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day9Part1Test extends TestCase
{
    public Day9Part1 $instance;
    public array $example = [];

    #[\Override]
    public function setUp(): void
    {
        $example = <<<EOS
        7,1
        11,1
        11,7
        9,7
        9,5
        2,5
        2,3
        7,3
        EOS;
        $this->example = explode(PHP_EOL, $example);
        $this->instance = new Day9Part1();
    }

    #[DataProvider('provideSquares')]
    public function testGetSizeBetween(string $a, string $b, int $size): void
    {
        $this->assertEquals($size, $this->instance->getSizeBetween($a, $b), $this->instance->getLog());
    }

    public static function provideSquares(): iterable
    {
        yield '2,5->9,7' => ['2,5', '9,7', 24];
        yield '9,7->2,5' => ['9,7', '2,5', 24];
        yield '7,1->11,7' => ['7,1', '11,7', 35];
        yield '11,7->7,1' => ['11,7', '7,1', 35];
        yield '7,3->2,3' => ['7,3', '2,3', 6];
        yield '2,3->7,3' => ['2,3', '7,3', 6];
    }

    public function testSolveWithExample(): void
    {
        $expectedOutput = 50;
        $instance = new Day9Part1();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
