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
        $sort_mode = SORT_NATURAL | SORT_FLAG_CASE;

        switch ($input) {
            case 'A':
                //sort alphabetically
                asort($array, $sort_mode);
                break;
            case 'Z':
                //sort reverse alphabetically
                arsort($array, $sort_mode);
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
    } elseif ($result == 'E' || empty($result)) {
        array_push($array, $new_Item);
    }
    
    return $array;
}

// open in a file
function open_file() {

    $filename = 'data/list.txt';
    //initiate our array to dump
    $list = [];

    if (is_readable($filename)) {
        
        $filesize = filesize($filename);
        //open file to read
        $read = fopen($filename, 'r');
        //read file into string
        $list_string = trim(fread($read, $filesize));
        //turn string into array
        $list = explode("\n", $list_string);
        //close the file
        fclose($read);
    } else {

        echo 'File is not readable.' . PHP_EOL;

    } 
    //dump the array
    return $list;
}


//save the list to a file
function save($list, $file) {
    //open the file for writing
    $write = fopen($file, 'w');
    //turn the array into a string
    $string = implode("\n", $list);
    // write the string onto the file
    fwrite($write, $string . "\n");
    //close the file
    fclose($write);
}


//where is it saving?
function choose_file($list, $file) {
    
    // does file exist already?
    if(file_exists($file)){
        
        fwrite(STDOUT, "This file already exists. Would you like to overwrite? (Y)es or (N)o?: ");

        $choice = get_input(true);
        // do they want to overwrite?
        if($choice == 'Y'){
       
            save($list, $file);
            echo "$file overwrite was succesful.\n";

        } else {
            //cancel the save
            fwrite(STDOUT, "Save aborted." . PHP_EOL);

        }

    } else {
            
          save($list, $file);
          echo "New file $file was created.\n";        
        
    }
}




// The loop!
do {

    echo list_items($items);
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort items, (O)pen file, s(A)ve file, (Q)uit : ';

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
        //sort the list
        $items = sort_menu($items);
    } elseif ($input == 'F') {
        //remove first item
        array_shift($items);
    } elseif ($input == 'L') {
        //remove last item
        array_pop($items);
    } elseif ($input == 'O') {
        //open a file
        $new_items = open_file();
        $items = array_merge($items,$new_items);
    } elseif($input == 'A') {
        //save the list
        fwrite(STDOUT, 'What file would you like to save to?: ');
        $filename = get_input();
        choose_file($items, $filename);

    }
    
// Exit when input is (Q)uit
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);


?>