<?php declare(strict_types=1);

namespace Ewald\AdventOfCode2025\Tests\Day2;

use Ewald\AdventOfCode2025\Day2\Day2Part1;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class Day2Part1Test extends TestCase
{
    #[DataProvider('provideWrongIds')]
    public function testIsWrongId(int $input, bool $out): void
    {
        $day2a = new Day2Part1();
        $this->assertSame($out, $day2a->isWrongId($input), $day2a->getLog());
    }

    #[DataProvider('provideBasic')]
    public function testGetWrongIds(string $input, array $out): void
    {
        $day2a = new Day2Part1();
        $this->assertSame($out, $day2a->getWrongIdsFromRange($input), $day2a->getLog());
    }

    public function testWithExample(): void
    {
        $day2a = new Day2Part1();
        $example = '11-22,95-115,998-1012,1188511880-1188511890,222220-222224,1698522-1698528,446443-446449,38593856-38593862,565653-565659,824824821-824824827,2121212118-2121212124';
        $this->assertSame(1227775554, $day2a->run($example), $day2a->getLog());
    }

    /**
     * @return iterable<string: array{0: int, 1: bool}>
     */
    public static function provideWrongIds(): iterable
    {
        yield '55' => [55, true];
        yield '56' => [56, false];
        yield '6464' => [6464, true];
        yield '6465' => [6465, false];
        yield '123123' => [123123, true];
        yield '123124' => [123124, false];
        yield '101' => [101, false];
        yield '11' => [11, true];
        yield '22' => [22, true];
        yield '99' => [99, true];
        yield '1010' => [1010, true];
        yield '1188511885' => [1188511885, true];
        yield '222222' => [222222, true];
        yield '446446' => [446446, true];
        yield '38593859' => [38593859, true];
    }

    /**
     * @return iterable<string: array{0: string, 1: int}>
     */
    public static function provideBasic(): iterable
    {
        yield '11-22 has two invalid IDs, 11 and 22' => ['11-22', [11, 22]];
        yield '95-115 has one invalid ID, 99' => ['95-115', [99]];
        yield '998-1012 has one invalid ID, 1010' => ['998-1012', [1010]];
        yield '1188511880-1188511890 has one invalid ID, 1188511885' => ['1188511880-1188511890', [1188511885]];
        yield '222220-222224 has one invalid ID, 222222' => ['222220-222224', [222222]];
        yield '1698522-1698528 contains no invalid IDs' => ['1698522-1698528', []];
        yield '446443-446449 has one invalid ID, 446446' => ['446443-446449', [446446]];
        yield '38593856-38593862 has one invalid ID, 38593859' => ['38593856-38593862', [38593859]];
    }
}
