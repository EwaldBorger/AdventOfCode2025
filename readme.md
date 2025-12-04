# Advent of Code 2025

Wanting to play along for years, this year I decided to just go for it :)

See https://adventofcode.com/2025/

I'm working in my "native" language of PHP, which might not be fast, but I know my way around it as I've been using it
since PHP3 as hobby and professionally since 2004.

As a way for me to try out Gemini, I also feed just the puzzle to it (at work we've got a GSuite license), but only
AFTER I solved it myself first. Just two days in I'm impressed with it, only using the 'fast' mode, not even '3 Pro'.

**Current score: 6⭐**

<!-- TOC -->
* [Advent of Code 2025](#advent-of-code-2025)
  * [Day 1](#day-1)
    * [Part 1 ⭐](#part-1-)
    * [Part 2 ⭐](#part-2-)
  * [Day 2](#day-2)
    * [Part 1 ⭐](#part-1--1)
    * [Part 2 ⭐](#part-2--1)
  * [Day 3](#day-3)
    * [Part 1 ⭐](#part-1--2)
    * [Part 2 ⭐](#part-2--2)
  * [Runtimes](#runtimes)
<!-- TOC -->

## Day 1

### Part 1 ⭐

That was kinda easy, correct answer on the first try.

### Part 2 ⭐

That was less easy... had to submit 8 times and refactor to have nice unit tests and a crude logging and such AND
go to the subreddit to find out what was wrong.

The subreddit hinted at testing for `L50 L50`, `R50 L50` which should return `1`, and `L150 L50` and such which should
return `2`. The problem was in the edge case where we start or end on 0 and do multiples of 100.
The code is messy and slow, but it did provide the right answer.

Gemini fortunately needed the same hint to get working code, but its code is a bit more elegant.

## Day 2

Both were relatively easy to solve, though my solutions are not the most elegant I think.

### Part 1 ⭐

The default thinking was to just split the id and compare both halves and if it was an uneven length don't even try.

Gemini took a very different approach and in the first part it directly had a solution but using GMP extension,
which I don't have. Second try it used bcmath, which I don't have installed as well.
Third try I asked it to use plain PHP, and it did and it worked.

### Part 2 ⭐

This was just the same, I even only extended my first solution and just split it every way possible and
count unique blocks.

Gemini had no issues in this part and its solution is a lot faster than mine.

## Day 3

### Part 1 ⭐

Needed three tries, even though the second was dumb to submit because it was higher than the previous one that already
was too high. Got another off by one I think, were I got higher numbers than possible.

### Part 2 ⭐

Took some runs of the unit tests, but able to submit the right answer in one try.


## Runtimes

| Puzzle | Tries me | Tries gemini | Runtime me | Runtime gemini |
|--------|----------|--------------|------------|----------------|
| 1-1    | 1        | 1            | 0m0,074s   | 0m0,053s       |
| 1-2    | 8        | 2            | 0m0,083s   | 0m0,056s       |
| 2-1    | 1        | 3            | 0m2,263s   | 0m2,797s       |
| 2-2    | 1        | 1            | 0m12,895s  | 0m2,830s       |
|        |          |              |            |                |
|        |          |              |            |                |
|        |          |              |            |                |
