<?php

function did_cross_previous_path($A) {
    for ($i = 3; $i < count($A); $i++) {

        if (
              $A[$i-1] <= $A[$i-3] && // 1
              (
                $A[$i] >= $A[$i-2] || // 2
                (
                  $A[$i-1] >= $A[$i-3] - $A[$i-5] &&  // 3.1
                  $A[$i] >= $A[$i-2] - $A[$i-4]       // 3.2
                )
              )
            )
        { return $i + 1; }

    }
    return 0;
}

$A = [1, 3, 2, 5, 4, 4, 6, 3, 2];
echo did_cross_previous_path($A);
?>
