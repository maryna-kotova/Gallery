<h1>Gallery</h1> 
<?php 
    $folders = scandir('sliders');
    foreach($folders as $folder)
    {   
        if($folder != '.' && $folder != '..' )
        {            
            echo "<div class='gallery2 $folder'>";                 
                echo '<p class="titleSlider">' . $folder . '</p>';
                echo '<div class="prev2"></div>';
                echo '<div class="next2"></div>';
                echo '<div class="window">';           
                    echo '<div class="sliderBox">';
                    $files = scandir('sliders/'.$folder);
                    foreach($files as $file)
                    {
                        if($file != '.' && $file != '..' && !is_dir("sliders/$folder/$file"))
                        {
                            $arrfile = explode('_', $file);                        
                            if($arrfile[0] == 'small')                        
                                echo "<img src='sliders/$folder/$file' rel='sliders/$folder/$arrfile[1]'>";                                     
                        }            
                    }
                    echo '</div>';                        
                echo '</div>'; 
            echo '</div>'; 
        }
    }
?>


