<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day4;

use Ewald\AdventOfCode2025\Day4\Day4Part1;
use Ewald\AdventOfCode2025\Day5\Day5Part1;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day5Part1Test extends TestCase
{
    public array $example = [
        '3-5',
        '10-14',
        '16-20',
        '12-18',
        '',
        '1',
        '5',
        '8',
        '11',
        '17',
        '32',
    ];

    public function testReadInput(): void
    {
        $instance = new Day5Part1();
        $instance->readInput($this->example);
        $this->assertEquals([3, 4, 5, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20], $instance->fresh, 'fresh ' . $instance->getLog());
        $this->assertEquals([1, 5, 8, 11, 17, 32], $instance->available, 'available ' . $instance->getLog());
    }

    public function testSolveWithExample(): void
    {
        $expectedOutput = 3;
        $instance = new Day5Part1();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
