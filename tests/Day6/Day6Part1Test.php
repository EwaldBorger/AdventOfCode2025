<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day6;

use Ewald\AdventOfCode2025\Day6\Day6Part1;
use PHPUnit\Framework\TestCase;

class Day6Part1Test extends TestCase
{
    public array $example = [
        '123 328  51 64 ',
        ' 45 64  387 23 ',
        '  6 98  215 314',
        '*   +   *   +  ',
    ];

    public function testReadInput(): void
    {
        $instance = new Day6Part1();
        $instance->readInput($this->example);
        $this->assertEquals(
            [
                0 => ['123', '45', '6', '*'],
                1 => ['328', '64', '98', '+'],
                2 => ['51', '387', '215', '*'],
                3 => ['64', '23', '314', '+'],
            ],
            $instance->todo,
            'todo ' . $instance->getLog(),
        );
    }

    public function testSolveWithExample(): void
    {
        $expectedOutput = 4277556;
        $instance = new Day6Part1();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
