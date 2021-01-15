<h1>Uploads</h1>
<?php showMessage('message') ?>  
 <!-- multipart/form-data - будет передаваться не название файла а сам файл -->
<form action="index.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="200000000">
    <input type="file" name="file" >
    <input type="hidden" name="action" value="uploadFile">
    <button class="btn btn-primary">Send</button>
</form>

<?php
    // dump( glob('images/*', GLOB_ONLYDIR) );

   /*  $files = glob('images/100x100*.{jpg,png,gif}', GLOB_BRACE);
    // dump($files);
    foreach($files as $file){
        echo "<img src='$file'>";
    } */
    /* $files = scandir('images');
    // dump($files);
    foreach($files as $file){
        if($file != '.' && $file != '..' && !is_dir("images/$file"))
        echo "<img src='images/$file'>";
    }  */
    $handle = opendir('images');   

    while( ($file=readdir($handle)) !== false ){
        if( $file != '.' && $file != '..' && !is_dir("images/$file") ){
            echo "<img src='images/$file'>";
        }
    }
    

?>