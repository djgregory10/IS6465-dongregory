<?php

//indexed arrays
$timeSlots = ["Morning", "Afternoon", "Evening"];
echo $timeSlots[0];        // Morning
echo $timeSlots[1];        // Afternoon
echo $timeSlots[2];        // Evening
echo '<br>';

//associative arrays
$request = [
    "course" => "IS 6465",
    "topic" => "PHP arrays",
    "status" => "Pending review"
];
echo $request["topic"];    // PHP arrays
echo '<br>';

//multidimensional arrays
$requests = [
    ["student" => "Amina", "course" => "IS 6465", "status" => "Pending review"],
    ["student" => "Diego", "course" => "IS 6495", "status" => "Matched"]
];
print_r( $requests[0]);

echo '<br>';

//foreach
$courses = ["IS 6465", "IS 6495", "IS 6570"];

foreach ($courses as $course) {
    echo "<option value='' . htmlspecialchars($course, ENT_QUOTES, 'UTF-8') . ''>";
    echo htmlspecialchars($course, ENT_QUOTES, "UTF-8") . "</option>";
}
echo '<br>';



?>

