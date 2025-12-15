<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day4;

use Ewald\AdventOfCode2025\Day4\Day4Part1;
use PHPUnit\Framework\TestCase;

class Day4Part1Test extends TestCase
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

    public function testGetGrid(): void
    {
        $input = ['.@', '@.'];
        $expected = [
            [0, 1],
            [1, 0],
        ];
        $instance = new Day4Part1();
        $grid = $instance->getGrid($input);
        $this->assertEquals($expected, $grid);
    }

    public function testGridToString(): void
    {
        $instance = new Day4Part1();
        $instance->grid = $instance->getGrid(['.@@', '@.@', '...']);
        $this->assertSame(".@@\n@.@\n...\n", $instance->gridToString());
    }

    public function testIsRollAt(): void
    {
        $instance = new Day4Part1();
        $instance->grid = $instance->getGrid(['.@@', '@.@', '...']);

        $this->assertFalse($instance->isRollAt(-1, -1), '-1,-1 outside');

        $this->assertFalse($instance->isRollAt(-1, 0), '-1,0 outside');
        $this->assertFalse($instance->isRollAt(0, 0), '0,0');
        $this->assertTrue($instance->isRollAt(1, 0), '1,0');
        $this->assertTrue($instance->isRollAt(2, 0), '2,0');
        $this->assertFalse($instance->isRollAt(3, 0), '3,0 outside');

        $this->assertFalse($instance->isRollAt(-1, 1), '-1,1 outside');
        $this->assertTrue($instance->isRollAt(0, 1), '0,1');
        $this->assertFalse($instance->isRollAt(1, 1), '1,1');
        $this->assertTrue($instance->isRollAt(2, 1), '2,1');
        $this->assertFalse($instance->isRollAt(3, 1), '3,1 outside');

        $this->assertFalse($instance->isRollAt(-1, 2), '-1,2 outside');
        $this->assertFalse($instance->isRollAt(0, 2), '0,2');
        $this->assertFalse($instance->isRollAt(1, 2), '1,2');
        $this->assertFalse($instance->isRollAt(2, 2), '2,2');
        $this->assertFalse($instance->isRollAt(3, 2), '3,2 outside');

        $this->assertFalse($instance->isRollAt(3, 3), '3,3 outside');
    }

    public function testIsRollAtExample(): void
    {
        $instance = new Day4Part1();
        $instance->grid = $instance->getGrid($this->example);
        $s = $instance->gridToString();

        $this->assertFalse($instance->isRollAt(-10, -10), "-10,-10\n" . $s);
        $this->assertFalse($instance->isRollAt(-10, 0), "-10,0\n" . $s);
        $this->assertFalse($instance->isRollAt(0, 0), "0,0\n" . $s);
        $this->assertTrue($instance->isRollAt(5, 0), "5,0\n" . $s);
        $this->assertTrue($instance->isRollAt(6, 0), "6,0\n" . $s);
        $this->assertTrue($instance->isRollAt(7, 0), "7,0\n" . $s);
        $this->assertTrue($instance->isRollAt(8, 0), "8,0\n" . $s);
    }

    public function testIsRollAccessible(): void
    {
        $instance = new Day4Part1();
        $instance->grid = $instance->getGrid(['@@@@', '@@@@', '@@@@', '@@@@']);
        $s = $instance->gridToString();
        $this->assertTrue($instance->isRollAccessible(0, 0), "0,0\n" . $s);
        $this->assertFalse($instance->isRollAccessible(1, 0), "1,0\n" . $s);
        $this->assertFalse($instance->isRollAccessible(2, 0), "2,0\n" . $s);
        $this->assertTrue($instance->isRollAccessible(3, 0), "3,0\n" . $s);

        $this->assertFalse($instance->isRollAccessible(0, 1), "0,1\n" . $s);
        $this->assertFalse($instance->isRollAccessible(1, 1), "1,1\n" . $s);
        $this->assertFalse($instance->isRollAccessible(2, 1), "2,1\n" . $s);
        $this->assertFalse($instance->isRollAccessible(3, 1), "3,1\n" . $s);

        $this->assertFalse($instance->isRollAccessible(0, 2), "0,2\n" . $s);
        $this->assertFalse($instance->isRollAccessible(1, 2), "1,2\n" . $s);
        $this->assertFalse($instance->isRollAccessible(2, 2), "2,2\n" . $s);
        $this->assertFalse($instance->isRollAccessible(3, 2), "3,2\n" . $s);

        $this->assertTrue($instance->isRollAccessible(0, 3), "0,3\n" . $s);
        $this->assertFalse($instance->isRollAccessible(1, 3), "1,3\n" . $s);
        $this->assertFalse($instance->isRollAccessible(2, 3), "2,3\n" . $s);
        $this->assertTrue($instance->isRollAccessible(3, 3), "3,3\n" . $s);
    }

    public function testSolveSimple3x3(): void
    {
        $expectedOutput = 4; // only the four corners
        $instance = new Day4Part1();
        $this->assertSame($expectedOutput, $instance->solve(['@@@', '@@@', '@@@']), $instance->getLog());
    }

    public function testSolveSimple4x4(): void
    {
        $expectedOutput = 4; // only the four corners
        $instance = new Day4Part1();
        $this->assertSame($expectedOutput, $instance->solve(['@@@@', '@@@@', '@@@@', '@@@@']), $instance->getLog());
    }

    public function testSolveWithExample(): void
    {
        $expectedOutput = 13;
        $instance = new Day4Part1();
        $this->assertSame($expectedOutput, $instance->solve($this->example), $instance->getLog());
    }
}
