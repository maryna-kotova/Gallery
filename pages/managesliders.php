<section class="createSliders">
       <div>
              <?php showMessage('message') ?>  
       </div>
<!-- ----- Сосдаем новый слайдер/папку --------------------------->
    <form action="index.php?page=<?= $page ?>" 
          method="POST"           
          class="manageSlide">  

        <span>Add Slider</span>      

        <input type="text" 
               name="sliderName"  
               placeholder="Name for new slider">   

        <input type="hidden" 
               name="action" 
               value="newSlider">   

        <button>+Slider</button>       
    </form>
<!-- ----- Добавляем картинки в выбранный слайдер/папку ------------------>
    <form action="index.php?page=<?= $page ?>" 
          method="POST" 
          enctype="multipart/form-data" 
          class="manageSlide">

        <span>Add images</span>                

        <select name="mySliders">
            <option value="choose">Choose slider</option>
            <?php
              $itemsFolder = opendir('sliders');
              while( ($folder=readdir($itemsFolder)) !== false ){
                     if( $folder != '.' && $folder != '..' ){                           
                            echo "<option value='$folder'>$folder</option>";
                     }
                 }
              ?>
        </select> 
        
       <input type="hidden" name="MAX_FILE_SIZE" value="200000000">        

       <input type="file" 
               name="yourImages[]" 
               id="yourImages" 
               multiple="multiple"
               accept="image/gif, image/jpeg, image/jpg, image/png, image/webp">
       <div id="previewImg"></div>

        <input type="hidden" 
               name="action" 
               value="uploadNewImage">  

        <button>+Images</button>       
    </form>
<!-- ----- Удаляем слайдер/папку ------------------------------------>
    <form action="index.php?page=<?= $page ?>" 
          method="POST"            
          class="manageSlide">

        <span>Remove slider</span>      

        <select name="allSliders">
            <option value="choose">Choose slider</option>
            <?php
              $itemsFolder = opendir('sliders');
              while( ($file=readdir($itemsFolder)) !== false ){
                     if( $file != '.' && $file != '..' ){                           
                            echo "<option value='$file'>$file</option>";
                     }
                 }
              ?>
        </select>       

        <input type="hidden" 
               name="action" 
               value="removeSlider">    
               
        <button>Delete</button>       
    </form>

</section>

