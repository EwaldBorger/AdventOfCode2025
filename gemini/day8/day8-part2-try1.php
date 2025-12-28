<?php

function solveJunctionBoxesPart2(array $input): string {
    $points = [];
    foreach ($input as $line) {
        if (preg_match('/(-?\d+),(-?\d+),(-?\d+)/', $line, $m)) {
            $points[] = [
                'x' => (int)$m[1],
                'y' => (int)$m[2],
                'z' => (int)$m[3],
                'id' => count($points)
            ];
        }
    }

    $numPoints = count($points);
    $edges = [];

    // 1. Calculate and Sort Edges (Same as Part 1)
    for ($i = 0; $i < $numPoints; $i++) {
        for ($j = $i + 1; $j < $numPoints; $j++) {
            $dx = $points[$i]['x'] - $points[$j]['x'];
            $dy = $points[$i]['y'] - $points[$j]['y'];
            $dz = $points[$i]['z'] - $points[$j]['z'];
            $distSq = ($dx * $dx) + ($dy * $dy) + ($dz * $dz);
            $edges[] = ['u' => $i, 'v' => $j, 'd' => $distSq];
        }
    }
    usort($edges, fn($a, $b) => $a['d'] <=> $b['d']);

    // 2. Union-Find Initialization
    $parent = range(0, $numPoints - 1);
    $numComponents = $numPoints;

    function find(&$parent, $i) {
        if ($parent[$i] === $i) return $i;
        return $parent[$i] = find($parent, $parent[$i]);
    }

    // 3. Connect until only ONE circuit remains
    foreach ($edges as $edge) {
        $rootU = find($parent, $edge['u']);
        $rootV = find($parent, $edge['v']);

        if ($rootU !== $rootV) {
            // This is a merge. Check if it's the very last one.
            if ($numComponents === 2) {
                // These are the last two boxes to be joined into a single circuit
                $boxA = $points[$edge['u']];
                $boxB = $points[$edge['v']];
                return (string)($boxA['x'] * $boxB['x']);
            }

            // Perform the merge
            $parent[$rootU] = $rootV;
            $numComponents--;
        }
    }

    return "No solution found";
}

// Verification with Example Data
$exampleInput = [
    "162,817,812", "57,618,57", "906,360,560", "592,479,940", "352,342,300",
    "466,668,158", "542,29,236", "431,825,988", "739,650,466", "52,470,668",
    "216,146,977", "819,987,18", "117,168,530", "805,96,715", "346,949,466",
    "970,615,88", "941,993,340", "862,61,35", "984,92,344", "425,690,689"
];

//echo "Example Final Connection Result: " . solveJunctionBoxesPart2($exampleInput) . " (Expected: 25272)\n";

echo "Final Connection Result: " . solveJunctionBoxesPart2(file('inputs/day8.txt')) . "\n";