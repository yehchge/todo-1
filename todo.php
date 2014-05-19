<?php

// Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
function list_items($array){
    $list = '';
    
    foreach($array as $key => $value) {

        // Display each item and a newline
        $list .= "[" . ($key + 1) . "] {$value}\n"; // $list = $list . "hello\n";
    
    }   
    return $list;

}

// Get STDIN, strip whitespace and newlines, 
// and convert to uppercase if $upper is true

function get_input($upper = FALSE) {

    $result = trim(fgets(STDIN));
    
    return $upper ? strtoupper($result) : $result;

}

function sort_menu($array) {

        echo '(A)-Z, (Z)-A, (O)rder entered, (R)everse order entered : ';

        $input = get_input(true);

        switch ($input) {
            case 'A':
                asort($array);
                break;
            case 'Z':
                arsort($array);
                break;
            case 'O':
                ksort($array);
                break;
            case 'R':
                krsort($array);
                break;
        }
        
        return $array;

}

function choose_place($array, $new_Item) {
    
    echo 'Would you like to add to the (B)eginning or the (E)nd: ';
    
    $result = get_input(true);
    if($result == 'B') {
        array_unshift($array, $new_Item);
    } elseif ($result == 'E') {
        array_push($array, $new_Item);
    } elseif(empty($reults)) {
        array_push($array, $new_Item);
    }
    
    return $array;
}


// The loop!
do {

    echo list_items($items);
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort items, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = get_input(true);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $new_Item = get_input();
        $items = choose_place($items,$new_Item);

    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = get_input();
        // Remove from array
        unset($items[$key-1]);
        //reset index counter
        $items = array_values($items);
    } elseif ($input == 'S') {
        $items = sort_menu($items);
    }
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);


?>