<?php declare(strict_types=1);

namespace Day4;

use Ewald\AdventOfCode2025\Day4\Day4Part1;
use Ewald\AdventOfCode2025\Day4\Day4Part2;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day4Part2Test extends TestCase
{
    public array $example = [
        '..@@.@@@@.',
        '@@@.@.@.@@',
        '@@@@@.@.@@',
        '@.@@@@..@.',
        '@@.@@@@.@@',
        '.@@@@@@@.@',
        '.@.@.@.@@@',
        '@.@@@.@@@@',
        '.@@@@@@@@.',
        '@.@.@@@.@.',
    ];

    public function testSolveSimple3x3(): void
    {
        $expectedOutput = 9; // all can be removed, first 4 corners, then the middle of the edges and then the middle one
        $instance = new Day4Part2();
        $this->assertSame($expectedOutput, $instance->solve(['@@@', '@@@', '@@@']), $instance->getLog());
    }

    public function testSolveSimple4x4(): void
    {
        $expectedOutput = 4; // still only the four corners
        $instance = new Day4Part2();
        $this->assertSame($expectedOutput, $instance->solve(['@@@@', '@@@@', '@@@@', '@@@@']), $instance->getLog());
    }

    public function testSolveWithExample(): void
    {
        $expectedOutput = 43;
        $instance = new Day4Part2();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
