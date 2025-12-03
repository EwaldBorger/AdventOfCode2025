<?php

/**
 * Solves the safe puzzle by counting every click that lands on 0 (Method 0x434C49434B).
 * This corrected version accurately handles multi-pass rotations and starting at 0/50.
 * * @param array $rotations An array of rotation strings (e.g., ["L68", "R48"]).
 * @return int The total number of times the dial points at 0.
 */
function solveSafePuzzleMethodClickCount(array $rotations): int {
    // The dial starts by pointing at 50.
    $currentPosition = 50;
    $totalZeroPasses = 0;

    foreach ($rotations as $rotation) {
        $rotation = trim($rotation);
        if (empty($rotation)) {
            continue;
        }

        // 1. Parse the rotation string
        $direction = substr($rotation, 0, 1);
        $distance = (int)substr($rotation, 1);
        $zeroPasses = 0;

        if ($direction === 'R') {
            // --- Right Rotation (R) Logic ---

            // Clicks needed to reach 0 for the first time:
            // If at 50, needs 50 clicks (50 + 50 = 100 -> 0).
            // If at 0, needs 100 clicks. The formula is (100 - currentPosition) % 100.
            // Since 100 % 100 is 0, let's use:
            $clicksToFirstZero = ($currentPosition === 0) ? 100 : (100 - $currentPosition);

            if ($distance >= $clicksToFirstZero) {
                // The first zero is passed
                $zeroPasses++;
                $remainingDistance = $distance - $clicksToFirstZero;

                // Subsequent zero passes occur every 100 clicks
                $zeroPasses += floor($remainingDistance / 100);
            }

            // Calculate final position
            $currentPosition = ($currentPosition + $distance) % 100;

        } elseif ($direction === 'L') {
            // --- Left Rotation (L) Logic ---

            // Clicks needed to reach 0 for the first time:
            // If at 50, needs 50 clicks (50 - 50 = 0).
            // If at 0, needs 100 clicks (0 - 100 = -100 -> 0).
            $clicksToFirstZero = ($currentPosition === 0) ? 100 : $currentPosition;

            if ($distance >= $clicksToFirstZero) {
                // The first zero is passed
                $zeroPasses++;
                $remainingDistance = $distance - $clicksToFirstZero;

                // Subsequent zero passes occur every 100 clicks
                $zeroPasses += floor($remainingDistance / 100);
            }

            // Calculate final position
            // Use the safe negative modulo calculation: ((a % n) + n) % n
            $currentPosition = ($currentPosition - $distance) % 100;
            if ($currentPosition < 0) {
                $currentPosition += 100;
            }

        } else {
            // Should not happen with valid input
            continue;
        }

        // 3. Accumulate total passes
        $totalZeroPasses += $zeroPasses;
    }

    return $totalZeroPasses;
}

// --------------------------------------------------------------------------------------------------

## 🧪 Testing with Provided Dataprovider

// The initial position of 50 is maintained inside the function.
$tests = [
    "10 - in one pass to the left" => [["L1000"], 10], // 50 - 1000 = -950 -> 50. Passes 0 at 50, 150, 250, 350, 450, 550, 650, 750, 850, 950. (10 times) -> CORRECT
    "10 - in one pass to the right" => [["R1000"], 10], // 50 + 1000 = 1050 -> 50. Passes 0 at 50, 150, 250, 350, 450, 550, 650, 750, 850, 950. (10 times) -> CORRECT
    "1 - basic pass to the left" => [["L75", "R20"], 1], // L75 (50->75: passed 0 once at 50 clicks) -> pos 75. R20 (75->95: no pass) -> pos 95. Total 1. -> CORRECT
    "1 - basic pass to the right" => [["R75", "L20"], 1], // R75 (50->25: passed 0 once at 50 clicks) -> pos 25. L20 (25->5: no pass) -> pos 5. Total 1. -> CORRECT
    "1 - left ending on zero LR" => [["L50", "R50"], 1], // L50 (50->0: passed 0 once at 50 clicks) -> pos 0. R50 (0->50: no pass) -> pos 50. Total 1. -> CORRECT
    "1 - left ending on zero LL" => [["L50", "L50"], 1], // L50 (50->0: passed 0 once at 50 clicks) -> pos 0. L50 (0->50: no pass) -> pos 50. Total 1. -> CORRECT
    "1 - right ending on zero RR" => [["R50", "R50"], 1], // R50 (50->0: passed 0 once at 50 clicks) -> pos 0. R50 (0->50: no pass) -> pos 50. Total 1. -> CORRECT
    "1 - right ending on zero RL" => [["R50", "L50"], 1], // R50 (50->0: passed 0 once at 50 clicks) -> pos 0. L50 (0->50: no pass) -> pos 50. Total 1. -> CORRECT

    "2 - basic pass to the left" => [["L200"], 2], // L200 (50->50: passed 0 at 50, 150 clicks). Total 2. -> CORRECT
    "2 - basic pass to the right" => [["R200"], 2], // R200 (50->50: passed 0 at 50, 150 clicks). Total 2. -> CORRECT
    "2 - extra pass left landing on zero LL" => [["L150", "L50"], 2], // L150 (50->0: passes 0 at 50, 150 clicks) -> pos 0. L50 (0->50: no pass) -> pos 50. Total 2. -> CORRECT
    "2 - extra pass left landing on zero LR" => [["L150", "R50"], 2], // L150 (50->0: passes 0 at 50, 150 clicks) -> pos 0. R50 (0->50: no pass) -> pos 50. Total 2. -> CORRECT
    "2 - extra pass right landing on zero RL" => [["R150", "L50"], 2], // R150 (50->0: passes 0 at 50, 150 clicks) -> pos 0. L50 (0->50: no pass) -> pos 50. Total 2. -> CORRECT
    "2 - extra pass right landing on zero RR" => [["R150", "R50"], 2], // R150 (50->0: passes 0 at 50, 150 clicks) -> pos 0. R50 (0->50: no pass) -> pos 50. Total 2. -> CORRECT

    "test example" => [["L68", "L30", "R48", "L5", "R60", "L55", "L1", "L99", "R14", "L82"], 6], // -> CORRECT
];

// --- Main execution block ---
$inputFile = 'inputs/day1.txt';

if (!file_exists($inputFile)) {
    // If the input file is missing, we'll run the tests for verification.
    echo "Error: The input file '$inputFile' was not found. Running verification tests...\n";
    echo "--------------------------------------------------------------------\n";
    $allPassed = true;
    foreach ($tests as $description => $data) {
        [$rotations, $expected] = $data;
        $actual = solveSafePuzzleMethodClickCount($rotations);
        $status = ($actual === $expected) ? "✅ PASS" : "❌ FAIL";
        if ($actual !== $expected) { $allPassed = false; }
        echo "Test: $description | Expected: $expected | Actual: $actual | $status\n";
    }
    echo "--------------------------------------------------------------------\n";
    if ($allPassed) {
        echo "All verification tests passed. Please ensure 'input.txt' is available for the final answer.\n";
    }
    die();
}

$rotations = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// 3. Solve the puzzle
$password = solveSafePuzzleMethodClickCount($rotations);

// 4. Output the result
echo "The new password (total clicks that land on 0) is: **$password**\n";

?>