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

function get_input($upper = false) {

    $result = trim(fgets(STDIN));
    
    return $upper ? strtoupper($result) : $result;

}

// function to sort menu
function sort_menu($array) {

        echo '(A)-Z, (Z)-A, (O)rder entered, (R)everse order entered : ';

        $input = get_input(true);
        $sort_mod = SORT_NATURAL | SORT_FLAG_CASE;

        switch ($input) {
            case 'A':
                //sort alphabetically
                asort($array, $sort_mod);
                break;
            case 'Z':
                //sort reverse alphabetically
                arsort($array, $sort_mod);
                break;
            case 'O':
                //sort by original key value
                ksort($array);
                break;
            case 'R':
                //sort by reverse key value
                krsort($array);
                break;
        }
        
        return $array;

}

//allow user to choose to append or prepend.
function choose_place($array, $new_Item) {
    
    echo 'Would you like to add to the (B)eginning or the (E)nd of your list? : ';
    
    $result = get_input(true);
    if($result == 'B') {
        array_unshift($array, $new_Item);
    } elseif ($result == 'E') {
        array_push($array, $new_Item);
    } elseif(empty($result)) {
        array_push($array, $new_Item);
    }
    
    return $array;
}

function import_list() {

    $filename = 'data/list.txt';

    $filesize = filesize($filename);

    $read = fopen($filename, 'r');

    $list_string = fread($read, $filesize);

    $list = explode("\n", $list_string);

    return $list;

    fclose($read);
}


// The loop!
do {

    echo list_items($items);
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort items, (I)mport list, (Q)uit : ';

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
        //reset index counter (optional)
        //$items = array_values($items);
    } elseif ($input == 'S') {
        $items = sort_menu($items);
    } elseif ($input == 'F') {
        array_shift($items);
    } elseif ($input == 'L') {
        array_pop($items);
    } elseif ($input == 'I') {
        $new_items = import_list();
        foreach ($new_items as $item) {
            array_push($items, $item);
        }
    }
    
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);


?>