<?php 
    header ("Content-type: image/png");  
    $widthImage = 300; 
    $heightImage = 400; 
    $img = imagecreate($widthImage, $heightImage); 

    $blancColor = ImageColorAllocate ($img, 255, 255, 255);  
    $lineColor  = ImageColorAllocate ($img, 226, 226, 226);  
    $textColor  = ImageColorAllocate ($img, 110, 110, 110);      

    imagefill($img, 0, 0, $blancColor);      
    
    $arrColorVotes = [];
    $arrCountVotes = []; 
    $arrRectangleColor =[]; 
    $count = 0;  
    $listVotes = file('../txt/vote.txt'); 

    foreach ( $listVotes as $listVote ) { 
        $arrlistVote = explode(':', $listVote);  
        array_push( $arrColorVotes, $arrlistVote[0] );        
        array_push( $arrCountVotes, trim($arrlistVote[1]) ); 
        $count += 1*(trim($arrlistVote[1])); 
        if($arrlistVote[0] == 'Red' ){
            $color = ImageColorAllocate ($img, 255, 0, 0); 
            array_push( $arrRectangleColor, $color );
        }
        elseif($arrlistVote[0] == 'Blue'){
            $color = ImageColorAllocate ($img, 0, 0, 255); 
            array_push( $arrRectangleColor, $color );
        }      
        elseif($arrlistVote[0] == 'Green'){
            $color = ImageColorAllocate ($img, 0, 128, 0); 
            array_push( $arrRectangleColor, $color );
        } 
        elseif($arrlistVote[0] == 'Yellow'){
            $color = ImageColorAllocate ($img, 255, 255, 0); 
            array_push( $arrRectangleColor, $color );
        }  
    }    
     // проводим горизонтальные линии  
    for ($i=0; $i < 11; $i++) { 
        ImageLine($img, 
                  35, 
                  $i*$heightImage/11+8, 
                  $widthImage-10, 
                  $i*$heightImage/11+8, 
                  $lineColor);
    }    
    //Выводим проценты по вертикали
    for ($i=0; $i < 11; $i++) { 
        $x = 0;
        $y = $i*($heightImage)/11; 
        $string =(100- $i*10) . '%';      
        ImageString ($img, 4, $x, $y, $string, $textColor);      
    }     
    // рисуем график
    for ($i=1; $i<=count($arrColorVotes); $i++) { 
        if($count == 0){
            $count = 1;                                  
        }
        if($arrCountVotes[$i-1] == 0){             
            $y1 = $heightImage-29;
                                   
        }else {
            $heightImagRectangle = round(($arrCountVotes[$i-1]*($heightImage-8))/$count);             
            $y1 = $heightImage-$heightImagRectangle - $heightImage/21;               
        }          
        $x1 =  $i*60;         
        $x2 = $i*60+40;
        $y2 = $heightImage-29;
        ImageFilledRectangle($img, $x1, $y1, $x2, $y2, $arrRectangleColor[$i-1]);          
    }    
    ImagePng ($img); 
    imagedestroy($img);



