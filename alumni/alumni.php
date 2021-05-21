<?php
include "config.php";
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $rollno = $_POST["rollno"];
    $email = $_POST["email"];
    $countrycode = $_POST["countryCode"];
    $phone = $_POST["phone"];
    $department = $_POST["department"];
    $year = $_POST["yearofpassing"];
    $qualification = $_POST["qualification"];
    $otherqualification = $_POST["other"];
    $organization = $_POST["organization"];
    $designation = $_POST["designation"];
    $domain = $_POST["domain"];
    $country = $_POST["country"];
    $linkdin = $_POST["linkdin"];
    $facebook = $_POST["facebook"];
    $instagram = $_POST["instagram"];

    //below query is used to prevent duplicate entries (one entry for each roll number)
    $dup = mysqli_query($conn, "select * from alumni_details where rollno='$rollno'");
    $checkrows = mysqli_num_rows($dup);
    if ($checkrows > 0) {
        echo "It's duplicate entry! You have already filled";
    } else {
        if (($_FILES['photo']['name'] != "")) {
            // Where the file is going to be stored

            $target_dir = "images/";
            $file = $_FILES['photo']['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];

            $ext = $path['extension'];
            $temp_name = $_FILES['photo']['tmp_name'];
            $path_filename_ext = $target_dir . $rollno . "." . $ext;
            $type = 'upload/' . $file;

            // Check if file already exists
            if (file_exists($path_filename_ext)) {
                echo "Something went wrong! Rename your document with your Roll Number and try again";
            } else {
                move_uploaded_file($temp_name, $path_filename_ext);
                echo "File uploaded successfully!";

                $sql = "INSERT INTO `alumni_details` (`s.no`, `name`, `rollno`, `email`, `phone`, `department`, `year`, `qualification`, `organization`, `designation`, `domain`, `country`, `photo`, `linkdin`, `facebook`, `instagram`) VALUES ('','$name' , '$rollno' , '$email','$countrycode $phone','$department','$year','$qualification-$otherqualification','$organization','$designation','$domain','$country','$rollno.$ext','$linkdin','$facebook','$instagram')";

                if (mysqli_query($conn, $sql)) {
                    echo "Your details submitted successfully.";
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }

                mysqli_close($conn);
            }
        }
    }
}
?>
