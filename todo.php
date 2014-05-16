<?php

// Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
function list_items($array)
{
    $list = '';
    
    foreach($array as $key => $value) {
        $key++;
        // Display each item and a newline
        $list .= "[{$key}] {$value}\n";
    }
    
    return $list;

}

// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true

function get_input($upper = FALSE) 
{
    if($upper) {
        return strtoupper(trim(fgets(STDIN)));
    } else {
        return trim(fgets(STDIN));
    }
}


// The loop!
do {

    echo list_items($items);
    // Show the menu options
    echo '(N)ew item, (R)emove item, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = strtoupper(get_input(true));

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $items[] = get_input();
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = get_input();
        // Remove from array
        unset($items[$key-1]);
        //reset index counter
        $items = array_values($items);
    }
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);


?>