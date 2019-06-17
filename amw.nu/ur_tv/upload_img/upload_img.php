<?php
ini_set('display_errors', 1);
//$art_id = $_SESSION['art_id'];
//if (!$session_title) {
//    $message = 'Choose an article above';
//} else {
//    $mesage = 'Upload Images for ' . $session_title;
//}
$mysqli = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

if ((count($_POST) > 0) OR ( count($_FILES) > 0)) {
    $name = utf8_decode($_POST['name']);
    $filename = $_FILES["myimage"]["name"];
    $microtime = microtime();
    $microtime_arr = explode(' ', $microtime);
    $filename = $microtime_arr[1] . '_' . $filename;
    $img_path = '../item_img/' . $filename;
    $tmp_name = $_FILES["myimage"]['tmp_name'];


    if (move_uploaded_file($tmp_name, $img_path)) {

        echo $sql_upload = "UPDATE `tv2_equipment` SET `img` = '$filename' WHERE `name` = '$name'";


        if ($mysqli->query($sql_upload)) {
            echo 'huurraa';
        }
    } else {
        $message = 'Upload image and fill out a title. ';
    }
}
?>
<div class="container">
    <?php // echo $art_id;   ?>
    <div class="upload-msg"></div>
    <div class="row row_center" >
        <div class="col-md-10">
            <h2><?php echo $mesage; ?></h2>
            <form method="post" action="" enctype="multipart/form-data" id="upload_item_form">
                <h3><?php echo $message; ?></h3>
                <div class="form-group">
                    <label for="exampleTextarea">Image name</label>
                    <input class="form-control" name='name' placeholder="optional" id="name">
                </div>            
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp" name="myimage" style="margin: auto;">
                    <!--<small id="fileHelp" class="form-text text-muted">Remeber to check the box, if the image is a hero image for the carousel</small>-->
                </div>  
                <!--<input type="hidden" name="art_id" value="<?php // echo $art_id;     ?>">-->
                <button type="submit" class="btn btn-primary" id="upload_submit" >Submit</button>
            </form>
        </div>
    </div>
</div>
<!--
<script>

    $(document).ready(function () {
        $("#upload_submit").click(function () {
            var img_title = $('#img_title').val();
//            alert(img_title);
            var filename = '<?php // echo $filename;     ?>';
            var file = $('#exampleInputFile').val();
//            alert(file);
            var fakepath = 'C:\\fakepath\\';
            var file = file.replace(fakepath, '');
//            alert(file);
           // var art_id = <?php // echo $art_id;   ?>;
//            alert(art_id);
            $.ajax({
                type: 'POST',
                url: 'handlers/upload_image_helper.php',
                data: {
                    'file': file,
                    img_title: img_title,
                    name:  <?php //  echo $name;   ?>;
                },
                success: function (response) {
                    alert(response);
                    window.location.reload();
                    window.scrollTo(0, 0);
                }
            });
        });
    });





//    $(document).ready(function (e) {
//
//    $("#upload_item_form").on('submit', (function(e) {
//    e.preventDefault();
//		$(".upload-msg").text('Loading...');	
////            var art_id = <?php // echo $art_id;      ?>;
////            alert(art_id)
//            $.ajax({
//            url: "handlers/upload_image_helper.php", // Url to which the request is send
//                    type: "POST", // Type of request to be send, called as method
//                    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
//                    contentType: false, // The content type used when sending data to the server.
//                    cache: false, // To unable request pages to be cached
//                    processData:false, // To send DOMDocument or non processed data file it is set to false
//                    success: function(data)   // A function to be called if request succeeds
//                    {
//                    $(".upload-msg").html(data);
//                    }
//            });
//   
//}));
//});




</script>
-->