<?php
session_start();
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
</head><body>no images yet<br>

<link href="notes.css" rel="stylesheet" type="text/css" media="screen">






<div id="wrapper">
    <form action="notes.php" enctype="multipart/form-data" method="post">
        <h2 id="header"><?php echo $_SESSION['user']; ?> - <span><a href="logout.php">Log out</a></span></h2>


        <div id="section1">

            <div id="column1">
                <h2>notes</h2>
                <textarea cols="16" rows="40" id="notes" name="notes"></textarea>
            </div>

            <div id="column2">
                <h2>websites</h2><h3>click to open</h3>



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


                </div>



            </div>

            <div id="column4">
                <h2>tbd</h2>
                <textarea cols="16" rows="40" id="tbd" name="tbd"></textarea>
            </div>

        </div>

        <div id="footer">
            <input type="submit" value="Save" style="width:200px;height:80px" name="submitting">
        </div>

    </form></div>


</body></html>