<?php

$message = ''; // message in case of successful append
$error = ''; // error message if one of the form fields not filled in

if(isset($_POST["submit"]))
{
    if(empty($_POST["name"]))
    {
        $error = "<label class='text-danger'>Enter the event name</label>";
    }
    else if(empty($_POST["eventDate"]))
    {
        $error = "<label class='text-danger'>Select event date</label>";
    }
    else if(empty($_POST["eventDescription"]))
    {
        $error = "<label class='text-danger'>Enter even description</label>";
    }
    else
    {
        if(file_exists('event_data.json')) // check if JSON-file exists in the current folder
        {
            $current_data = file_get_contents('event_data.json'); // Reads entire file into a string
            $array_data = json_decode($current_data, true); // Takes a JSON encoded string and converts it into a PHP variable.
            // When TRUE, returned objects will be converted into associative arrays.
            $extra = array(
                'name'=>$_POST['name'],
                'eventDate'=>$_POST["eventDate"],
                'eventDescription'=>$_POST["eventDescription"]
            );
            $array_data[] = $extra; // Adding new elements to existing array data from extra array
            $final_data = json_encode($array_data); // Returns a string containing the JSON representation of the supplied value.
            if(file_put_contents('event_data.json', $final_data)) // Write a string to a file
            {
                $message = "<label class='text-success'>Event appended successfully</p>";
            }
        }
        else
        {
            $error = 'JSON File does NOT exits';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Append Data to JSON File using PHP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<br />
<div class="container" style="width:500px;">
    <h3 align="">Append an Event to JSON File</h3><br/>
    <form method="post">
        <?php
        if(isset($error))
        {
            echo $error;
        }
        ?>
        <br />
        <label>Event Name</label>
        <input type="text" name="name" class="form-control" placeholder="Put the event name here"/><br />
        <label>Date of event</label>
        <input type="date" name="eventDate" class="form-control" placeholder="Choose date"/><br />
        <label>Event description</label>
        <input type="text" name="eventDescription" class="form-control" placeholder="Describe event briefly" /><br />
        <input type="submit" name="submit" value="Add a new event" class="btn btn-info" /><br />
        <?php
        if(isset($message))
        {
            echo $message;
        }
        ?>
        <br>
    </form>

    <form method="post" action="index.php">
        <input type="submit" name="submit" value="Back to calendar" class="btn btn-warning" /><br />
    </form>



</div>
<br />
</body>
</html>  