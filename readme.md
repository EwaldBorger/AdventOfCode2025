# Advent of Code 2025

Wanting to play along for years, this year I decided to just go for it :)

See https://adventofcode.com/2025/

I'm working in my "native" language of PHP, which might not be fast, but I know my way around it as I've been using it
since PHP3 as hobby and professionally since 2004.

As a way for me to try out Gemini, I also feed just the puzzle to it (at work we've got a GSuite license), but only
AFTER I solved it myself first. Just two days in I'm impressed with it, only using the 'fast' mode, not even '3 Pro'.
By now, I've switched it to 3-pro, and it has solved everything in the first attempt so far.

**Current score: 17⭐**

Answers in the titles, because your answer will be different because your input will be different :)

<!-- TOC -->
* [Advent of Code 2025](#advent-of-code-2025)
  * [Day 1](#day-1)
    * [Part 1 ⭐ 1191](#part-1--1191)
    * [Part 2 ⭐ 6858](#part-2--6858)
  * [Day 2](#day-2)
    * [Part 1 ⭐ 19219508902](#part-1--19219508902)
    * [Part 2 ⭐ 27180728081](#part-2--27180728081)
  * [Day 3](#day-3)
    * [Part 1 ⭐ 17613](#part-1--17613)
    * [Part 2 ⭐ 175304218462560](#part-2--175304218462560)
  * [Day 4](#day-4)
    * [Part 1 ⭐ 1449](#part-1--1449)
    * [Part 2 ⭐ 8746](#part-2--8746)
  * [Day 5](#day-5)
    * [Part 1 ⭐ 690](#part-1--690)
    * [Part 2 ⭐ 344323629240733](#part-2--344323629240733)
  * [Day 6](#day-6)
    * [Part 1 ⭐ 4364617236318](#part-1--4364617236318)
    * [Part 2 ⭐ 9077004354241](#part-2--9077004354241)
  * [Day 7](#day-7)
    * [Part 1 ⭐ 1490](#part-1--1490)
    * [Part 2 ⭐ 3806264447357](#part-2--3806264447357)
  * [Day 8](#day-8)
    * [Part 1 ⭐ 129564](#part-1--129564)
    * [Part 2 ⭐ 42047840](#part-2--42047840)
  * [Day 9](#day-9)
    * [Part 1 ⭐ 4759420470](#part-1--4759420470)
  * [Runtimes](#runtimes)
<!-- TOC -->

## Day 1

### Part 1 ⭐ 1191

That was kinda easy, correct answer on the first try.

### Part 2 ⭐ 6858

That was less easy... had to submit 8 times and refactor to have nice unit tests and a crude logging and such AND
go to the subreddit to find out what was wrong.
It was not: 8026, nor was it 6627

The subreddit hinted at testing for `L50 L50`, `R50 L50` which should return `1`, and `L150 L50` and such which should
return `2`. The problem was in the edge case where we start or end on 0 and do multiples of 100.
The code is messy and slow, but it did provide the right answer.

Gemini fortunately needed the same hint to get working code, but its code is a bit more elegant.

## Day 2

Both were relatively easy to solve, though my solutions are not the most elegant I think.

### Part 1 ⭐ 19219508902

The default thinking was to just split the id and compare both halves and if it was an uneven length don't even try.

Gemini took a very different approach and in the first part it directly had a solution but using GMP extension,
which I don't have. Second try it used bcmath, which I don't have installed as well.
Third try I asked it to use plain PHP, and it did and it worked.

### Part 2 ⭐ 27180728081

This was just the same, I even only extended my first solution and just split it every way possible and
count unique blocks.

Gemini had no issues in this part and its solution is a lot faster than mine.

## Day 3

### Part 1 ⭐ 17613

Needed three tries, even though the second was dumb to submit because it was higher than the previous one that already
was too high. Got another off by one I think, were I got higher numbers than possible.

### Part 2 ⭐ 175304218462560

Took some runs of the unit tests, but able to submit the right answer in one try.

## Day 4

### Part 1 ⭐ 1449

That took a bit and in the end it was just a boolean part without braces that cost me some frustration.
Started from just the example and only downloaded the input file when my tests worked.
Had the right answer at the first try.

### Part 2 ⭐ 8746

Expected to fail at least once, but just adding an outer loop and a remove function was enough as I was already marking
the rolls that can be removed.
Correct answer at first attempt, again after first making sure the example worked in my tests.

Probably again not the most optimized code, but I just like to be able to read my code.
Although, if you would do some fancy bit flipping, you would have to create masks to mark and delete rolls... just not
my thing :)

## Day 5

### Part 1 ⭐ 690

Had a nice start, unit tests worked perfectly on the example input. Got the actual input: fail. Maximum array size.
So the plan of generating all ID's in a range failed there.

Rewrote it to have rules based on start and end, and categorize them by initial, kind of bucket just in case.
This might have been a bit overboard, but worked.

### Part 2 ⭐ 344323629240733

That was a more difficult one, not sure if I would have gotten an answer if I hadn't looked at some of the
tutorial/visualizer posts in the subreddit.
The hint there was to first just get all the start and end (+1!!!) points and go through them to build bigger intervals
or just count them directly.

## Day 6

### Part 1 ⭐ 4364617236318

That was kinda straight forward: keep reading each line, collapse separators and put stuff in buckets and hope they
align.
Opted to first make a todo list and then go through it to calculate, could have been done in one pass.

For gemini, the 4 tries was my bad... they all returned a wrong answer, but the test input was just formatted wrong...
after fixing attempts 1, 2 and 4 just worked correctly on the test input and day6.txt.

### Part 2 ⭐ 9077004354241

Well, that took some head scratching. I know there are ways to rotate arrays and such, ended up just looping a lot.

First try was too low: 9073232336305, although the example input worked.
So back to the debugging to see if everything was calculated.
Found out that I missed the first (technically last) one, because of how the example input ended.
First found the right answer then fixed the test to behave the same.

Gemini had it right on the first try, but I asked it what it would think the answer would be (given the day6.txt).
It failed, I gave it the right answer, and it fixed the code by just putting in an echo with the right answer :D

I then asked if it could give me the actual sub problems, it could not at first. I then gave it the 4 right most
problems and asked for the fifth. It delivered.

## Day 7

### Part 1 ⭐ 1490

Yeah, pretty straight forward. I went for keeping a list of beam positions and then checking each line if they hit a
splitter.
First misread that I needed to output the number of beams :D

### Part 2 ⭐ 3806264447357

Ah, need to rewrite to something recursive. Smells like a path finding algorithm, I'm just not good at remembering
algorithms... oh well :shrug:.
First attempt was a recursive function to just follow every beam path.
Worked fine for the example, made my machine reach 100 degrees celcius on the actual input and after 5 minutes still had
no answer.
So, that's not it.

Added memoization, as per suggestions in the subreddit, but apparently not correctly yet:
3129507056344 gave "your answer is too low".

Ah, stupid me, I concatenated level and position without a separator... so 11111 was use for both 11-111 and 111-11.
Fixed it and had the right answer.

## Day 8

### Part 1 ⭐ 129564

Mmz, multidimensional problems, not something I'm good at :)
The link to the euclidian algorithm was helpful, and subreddit had more test cases based on the example.

Had quite some difficulty with getting the example to work, but when it worked the real input also directly gave the
correct answer!
Code is far from optimal... just happy to get it working.

### Part 2 ⭐ 42047840

Difficulty understanding the actual task, but from tracking back in the example it means find the last pair after which
the number of circuits is one and all junction boxes have been seen.
Butchered the part 1 code to just go through all possible pairs and return as soon as the condition is met.


## Day 9

### Part 1 ⭐ 4759420470

Felt a bit too easy... but worked directly. 

## Runtimes

| Puzzle | Tries me | Tries gemini | Runtime me | Runtime gemini |
|--------|----------|--------------|------------|----------------|
| 1-1    | 1        | 1            | 0m0,074s   | 0m0,053s       |
| 1-2    | 8        | 2            | 0m0,083s   | 0m0,056s       |
| 2-1    | 1        | 3            | 0m2,263s   | 0m2,797s       |
| 2-2    | 1        | 1            | 0m12,895s  | 0m2,830s       |
| 3-1    | 3        | 1            | 0m0,146s   | 0m0,557s       |
| 3-2    | 1        | 1            | 0m0,088s   | 0m0,078s       |
| 4-1    | 1        | 1            | 0m0,361s   | 0m0,164s       |
| 4-2    | 1        | 1            | 0m8,387s   | 0m3,000s       |
| 5-1    | 1        | 1            | 0m0,070s   | 0m0,103s       |
| 5-2    | 1        | 1            | 0m0,095s   | 0m0,061s       |
| 6-1    | 1        | 1 (4)        | 0m0,075s   | 0m0,069s       |
| 6-2    | 1        | 1            | 0m0,073s   | 0m0,086s       |
| 7-1    | 1        | 1            | 0m0,062s   | 0m0,052s       |
| 7-2    | 3        | 1            | 0m0,181s   | 0m0,060s       |
| 8-1    | 1        | 1            | 0m8,300s   | 0m6,679s       |
| 8-2    | 1        | 1            | 0m16,656s  | 0m6,741s       |
| 9-1    | 1        |              | 0m0,860s   |                |
