<?php

require_once 'lab2B.php';

// Lab 2: PHP Expressions and Control Structures

echo '<h1>Lab 2A: Expressions and Control Structures</h1>';

// 1. Expressions and Operators
echo '<h2>1. Expressions and Operators</h2>';

$x = -5;

// TODO: Write an expression that calculates:
// y = 3(abs(2x) + 4)
$y = 3 * (abs(2 * $x) + 4);

echo "The value of y is: $y<br>";

// 2. Boolean Comparisons
echo '<h2>2. Comparisons</h2>';

// TODO: Use var_dump() to compare:
// 2 > 1
// 2 == 3
// "5" == 5
// "5" === 5

var_dump(2 > 1);        // true
var_dump(2 == 3);       // false
var_dump("5" == 5);     // true
var_dump("5" === 5);    // false
echo '<br>';

// 3. Unary Operators
echo '<h2>3. Unary Operators</h2>';

// TODO: Create variables that demonstrate unary minus, unary plus,
// and pre-increment. Display the results.

$c = 5;
$d = -$c;       //unary minus
$e = +$c;
$f = ++$c;      //unary plus

echo $d;
echo '<br>';
echo $e;
echo '<br>';
echo $f;
echo '<br>';

// 4. Operator Precedence
echo '<h2>4. Operator Precedence</h2>';

// TODO: Compare the results of these two expressions:
// 2 + 3 * 4
// (2 + 3) * 4

$a = 2 + 3 * 4;     // 14, multiplication has higher precedence than addition
$b = (2 + 3) * 4;    // 20, parentheses change the order of operations

echo $a;
echo '<br>';
echo $b;
echo '<br>';

// 5. Assignment Associativity
echo '<h2>5. Assignment Associativity</h2>';

// TODO: Assign 0 to $level, $score, and $time in one statement.
// Display each variable.

$level = $score = $time = 0;
echo $level;
echo '<br>';
echo $score;
echo '<br>';
echo $time;
echo '<br>';

// 6. Equality and Assignment
echo '<h2>6. Equality and Assignment</h2>';

// TODO: Create variables with equal and unequal values.
// Use var_dump() to compare them with == and ===.

$a = 5;
$b = 5;
var_dump($a == $b);     // true
var_dump($a === $b);    // true
$c = 10;                
$d = 20;
var_dump($c == $d);     // false
var_dump($c === $d);     // false

// 7. Logical Operators
echo '<h2>7. Logical Operators</h2>';

// TODO: Use var_dump() to demonstrate &&, ||, and !.

$a = 1;
$b = 0;
$c = 1;
var_dump($a && $b);     // false
var_dump($a || $b);     // true
var_dump(!$a);          // false
var_dump(!$b);          // true


// 8. Scholarship Decision with if...else
echo '<h2>8. Scholarship Decision with if...else</h2>';

// TODO: Use if...else to display whether the student receives a scholarship.

//if
$gpa = 3.9;

if ($gpa >= 3.7){
    echo "Student gets scholarship";
}else{
    echo "Student does not get scholarship";
}
echo '<br>';

// 9. Scholarship Decision with if...elseif...else
echo '<h2>9. Scholarship Decision with if...elseif...else</h2>';

// TODO: Use if...elseif...else to display:
// Full scholarship for GPA 3.7 or higher
// Partial scholarship for GPA 3.5 through 3.69
// No scholarship otherwise

$gpa = 3.59;

if ($gpa >= 3.7){
    echo "Student gets scholarship";
}elseif ($gpa >= 3.5) {
    echo "Student gets partial scholarship";
}else{
    echo "Student does not get scholarship";
}
echo '<br>';

// 10. Access Status
echo '<h2>10. Access Status</h2>';

// TODO: Use a switch statement to display a message for:
// approved, pending, and all other statuses


$status = 'approved';
switch ($status) {
    case "approved":
    echo "Access granted";
    break;
    case "pending":
    echo "Review in progress";
    break;
    default:
    echo "Access denied";
    break;
}


// 11. While Loop
echo '<h2>11. While Loop</h2>';

// TODO: Create a while loop.
// Display "There is enough fuel" while fuel is greater than 1.
// Decrease fuel during each repetition.

$fuel = 10;
while ($fuel > 1) {
    echo "There is enough fuel<br>";
    $fuel--;
}
echo '<br>';

// 12. Multiplication Table
echo '<h2>12. Multiplication Table</h2>';

// TODO: Create a for loop that displays the 12-times table
// from 1 through 12.

for($count = 1; $count <= 12; $count++){
    echo $count . " times 12 is " .
    ($count * 12) . "<br>";
}
echo '<br>';
