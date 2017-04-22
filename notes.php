<?php
session_start();
require_once "initdb.php";
?>
<html><head>
    <title>Note-to-myself : notes</title>
    <link rel="shortcut icon" href="pencil.ico">
    <script type="text/javascript">
        function openInNew(textbox){
            window.open(textbox.value);
            this.blur();
        }
    </script>
</head><body>
<?php
if(empty($_SESSION['user']) || !accountExists($_SESSION['user'])) {
    die('<body>Please try again to <a href="register2.php">register</a> or <a href="index.php">log in</a>.</body>');
}

$user = strtolower(trim($_SESSION['user']));
$data = getUser($user);
$conn = getConn();

if(isset($_POST['submitting'])) {


    if(!empty($_FILES['i'])) {

		/*
       $images_folder = "uploadedimages/$user";

       if (!file_exists($images_folder)) {
           echo "Now actually creating $images_folder";
           if (!@mkdir($images_folder, 0777, true)) {
               $error = error_get_last();
               echo $error['message'];
           }
       }
		*/

		/*
       $target_file = $images_folder . "/" . basename($_FILES["i"]["name"]);
       if(move_uploaded_file($_FILES["i"]["tmp_name"], $target_file)) {
           //createThumb($target_file);
           addImageGetId($user, $target_file);
       }
	   */
	   addImageGetId($user, $_FILES["i"]);
    }

	if(!empty($_POST['delete']))
    foreach(@$_POST['delete'] AS $deleteImage) {

        $deleteImage = sanitizeInt($deleteImage);

        //$q1 = mysqli_query($conn, "SELECT link FROM images WHERE id = $deleteImage");
        //$image = $q1->fetch_assoc();
        //unlink($image['link']);
        //unlink(getThumbnailName($image['link']));
        $q2 = mysqli_query($conn, "DELETE FROM images WHERE id = $deleteImage");

    }

    $notes = $_POST['notes'];
    $tbd   = $_POST['tbd'];
    $websites = [];
    foreach($_POST['websites'] AS $site) {
        if(!empty(trim($site))) $websites[] = $site;
    }
    $sites = serialize($websites);



    updateUserStrings($_SESSION['user'],
        ['notes_text'=>$notes,
            'tbd_text'=>$tbd,
            'links_serialized'=>$sites]);
}




// Hmm doesn't correlate 100% between cause & message, but that's what the original site does
if(!$data['uploaded']) {
    echo 'no images yet<br>';
}


function addImageGetId($user, $file) {
    $user = strtolower(trim($user));
    $conn = getConn();

    if(!accountExists($user)) die('User doesn\'t exist!');

	$image = base64_encode(file_get_contents($file['tmp_name']));
	$thumb = base64_encode(getThumb($file));



	//echo "<img src=\"data:image/jpeg;base64,".base64_encode($image)."\"/>";
	//die();

	$q1 = mysqli_query($conn, "SELECT count(*) AS num FROM images WHERE user_email = '$user'");
	$object = mysqli_fetch_object($q1);
	if(!empty($object) && !empty($object->num) && $object->num >= 4)
		die('Cannot upload > 4 images! Delete some first.');

    $query = mysqli_query($conn, "INSERT INTO images (user_email, data, thumbnail) 
                                      VALUES ('$user', '$image', '$thumb')");
    //$query->execute();

    return mysqli_insert_id($conn);
}

// get the thumbnail name of this img
function getThumbnailName($img) { // {{{

    //$img = ltrim($img, './'); // don't need this


    $dir  = substr($img, 0,strrpos($img, '/'));
    $name = basename($img);

    return "$dir/thumb_$name";

} // }}}

function getThumb($img) {
    // trim beginning ./ if exists, to be consistent.
    //$img = ltrim($img, './');

    // get file extension
    $ext = pathinfo($img['name'], PATHINFO_EXTENSION);

    // get the "thumbnail name" of this filename
    //$thumbname = getThumbnailName($img);


    // create image in memory from file, handle specific filetypes
    $upperExt = strtoupper($ext);
    switch($upperExt) {
        case 'JPEG' :
        case 'JPG'  : $im = imagecreatefromjpeg($img['tmp_name']); break;
		//  case 'PNG'  : $im = imagecreatefrompng($img); break;
        case 'GIF'  : $im = imagecreatefromgif($img['tmp_name']); break;
        default : die("Only jpg and gif files are supported. <a href=\"notes.php\">Try again</a>.");
    }

    // get x & y dimensions
    $x = imagesx($im);
    $y = imagesy($im);


    // Resize, keeping aspect ratio.
    //  thus, the biggest dimension becomes 100,
    //  and the smaller dimension is resized relative to 100
    //  and the aspect ratio.
    if($x > $y) {

        $newX = 100;
        $newY = $y / $x * 100;
    }
    else {
        $newY = 100;
        $newX = $x / $y * 100;
    }

    // create destination image (in memory) for the thumbnail
    $th = imagecreatetruecolor($newX, $newY);

    // copy image data from source to thumbnail
    imagecopyresampled(
        $th,                  $im,
        0, 0,                 0, 0,
        $newX, $newY,         imagesx($im), imagesy($im));


	ob_start();
    // handle saving filetypes
    switch($upperExt) {

        case 'JPEG' :
        case 'JPG'  : imagejpeg($th, null, 100); break;
        //	case 'PNG'	: imagepng($th, $thumbname, 9); break;
        case 'GIF'	: imagegif($th, null); break;
        default : echo "fail";
    }
	$data = ob_get_contents();
	ob_clean();

    // cleanup
    //imagedestroy($im);

	return $data;

}


?>

<link href="notes.css" rel="stylesheet" type="text/css" media="screen">

<div id="wrapper">
    <form action="notes.php" enctype="multipart/form-data" method="post">
        <h2 id="header"><?php echo $user; ?> - <span><a href="logout.php">Log out</a></span></h2>


        <div id="section1">

            <div id="column1">
                <h2>notes</h2>
                <textarea cols="16" rows="40" id="notes" name="notes"><?php echo $data['notes_text']; ?></textarea>
            </div>

            <div id="column2">
                <h2>websites</h2><h3>click to open</h3>

                <?php
                foreach(unserialize($data['links_serialized']) AS $link) {
                    echo "<input type=\"text\" name=\"websites[]\" value=\"$link\" onclick=\"openInNew(this);\"><br>\n";
                }
                ?>
                <input type="text" name="websites[]"><br>
                <input type="text" name="websites[]"><br>
                <input type="text" name="websites[]"><br>
                <input type="text" name="websites[]"><br>

            </div>

        </div>

        <div id="section2">

            <div id="column3">
                <h2>images</h2><h3>click for full size</h3>
                <!-- <textarea cols="16" rows="40" id="image" name="image" /></textarea> -->

                <input type="file" name="i"><br><br>


                <div>
                    <?php
                        $result = mysqli_query($conn, "SELECT * FROM images where user_email = '$user'") or die(mysqli_error($conn));

                        while($img = mysqli_fetch_assoc($result)) {
                            //$file = $img['link'];
                            //$base = basename($file);
                            //$thumb = getThumbnailName($file);
							$thumb = "data:image/jpeg;base64,".$img['thumbnail'];

                            //echo "<a href=\"$file\" target=\"_blank\">
                             echo  "      <img src=\"$thumb\" >";
                             //     </a>
                            "<input type=\"checkbox\" name=\"delete[]\" value=\"$img[id]\"> <label for=\"delete[]\">delete</label>
        
                            <br><br>
                            ";
                        }
                    ?>


                </div>



            </div>

            <div id="column4">
                <h2>tbd</h2>
                <textarea cols="16" rows="40" id="tbd" name="tbd"><?php echo $data['tbd_text']; ?></textarea>
            </div>

        </div>

        <div id="footer">
            <input type="submit" value="Save" style="width:200px;height:80px" name="submitting">
        </div>

    </form></div>


</body></html>
