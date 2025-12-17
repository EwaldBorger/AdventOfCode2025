<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day7;

use Ewald\AdventOfCode2025\Day7\Day7Part1;
use PHPUnit\Framework\TestCase;

class Day7Part1Test extends TestCase
{
    public array $example = [
        '.......S.......',
        '...............',
        '.......^.......',
        '...............',
        '......^.^......',
        '...............',
        '.....^.^.^.....',
        '...............',
        '....^.^...^....',
        '...............',
        '...^.^...^.^...',
        '...............',
        '..^...^.....^..',
        '...............',
        '.^.^.^.^.^...^.',
        '...............',
    ];

    public function testSolveWithExample(): void
    {
        $expectedOutput = 21;
        $instance = new Day7Part1();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
