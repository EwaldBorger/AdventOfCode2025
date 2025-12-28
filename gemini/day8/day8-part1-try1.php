<?php

function solveJunctionBoxes(array $input, int $connectionLimit = 1000): string {
    $points = [];
    foreach ($input as $line) {
        if (preg_match('/(-?\d+),(-?\d+),(-?\d+)/', $line, $m)) {
            $points[] = ['x' => (int)$m[1], 'y' => (int)$m[2], 'z' => (int)$m[3]];
        }
    }

    $numPoints = count($points);
    $edges = [];

    // 1. Calculate all possible pair-wise distances
    for ($i = 0; $i < $numPoints; $i++) {
        for ($j = $i + 1; $j < $numPoints; $j++) {
            $dx = $points[$i]['x'] - $points[$j]['x'];
            $dy = $points[$i]['y'] - $points[$j]['y'];
            $dz = $points[$i]['z'] - $points[$j]['z'];
            // Using squared distance for sorting accuracy/speed
            $distSq = ($dx * $dx) + ($dy * $dy) + ($dz * $dz);
            $edges[] = ['u' => $i, 'v' => $j, 'd' => $distSq];
        }
    }

    // 2. Sort edges by distance
    usort($edges, fn($a, $b) => $a['d'] <=> $b['d']);

    // 3. Union-Find to track circuits
    $parent = range(0, $numPoints - 1);
    $size = array_fill(0, $numPoints, 1);

    function find(&$parent, $i) {
        if ($parent[$i] === $i) return $i;
        return $parent[$i] = find($parent, $parent[$i]);
    }

    // 4. Process the first X shortest connections
    for ($k = 0; $k < min($connectionLimit, count($edges)); $k++) {
        $rootU = find($parent, $edges[$k]['u']);
        $rootV = find($parent, $edges[$k]['v']);

        if ($rootU !== $rootV) {
            // Merge smaller circuit into larger one
            if ($size[$rootU] < $size[$rootV]) {
                [$rootU, $rootV] = [$rootV, $rootU];
            }
            $parent[$rootV] = $rootU;
            $size[$rootU] += $size[$rootV];
            $size[$rootV] = 0; // Mark this root as no longer a primary circuit
        }
    }

    // 5. Multiply the three largest circuit sizes
    $finalSizes = array_filter($size, fn($s) => $s > 0);
    rsort($finalSizes);

    $result = $finalSizes[0] * ($finalSizes[1] ?? 1) * ($finalSizes[2] ?? 1);
    return (string)$result;
}

// Verification with the 20-box example
$exampleInput = [
    "162,817,812", "57,618,57", "906,360,560", "592,479,940", "352,342,300",
    "466,668,158", "542,29,236", "431,825,988", "739,650,466", "52,470,668",
    "216,146,977", "819,987,18", "117,168,530", "805,96,715", "346,949,466",
    "970,615,88", "941,993,340", "862,61,35", "984,92,344", "425,690,689"
];

// In example, they connect only 10 pairs
//echo "Example (10 connections): " . solveJunctionBoxes($exampleInput, 10) . " (Expected: 40)\n";

echo "Real (1000 connections): " . solveJunctionBoxes(file('inputs/day8.txt'), 1000) . "\n";