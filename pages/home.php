<h1>Home page</h1>
<?php showMessage('message') ?>
<!-- <img src="images-php/test.php?red=128&green=0&blue=0" alt=""> -->
<!-- 
<form action="index.php?page=<?= $page ?>" method="POST" id="formVote">
    
    <b>What color do you like?</b> <br>
    <input type="Radio" name=vote value="Red"   >Red<br>
    <input type="Radio" name=vote value="Blue"  >Blue<br>
    <input type="Radio" name=vote value="Green" >Green<br>
    <input type="Radio" name=vote value="Yellow">Yellow<br>
    
    <input type="hidden" 
           name="action" 
           value="sendVote">

    <button id="formButton"> Голосовать! </button>    
</form>

<section id="charts"> 

    <div class="charts1">       
        <?php 
//         $f = fopen('txt/vote.txt', 'w+');
//         $fileVote = file('txt/vote.txt');  
//         if( count($fileVote) == 0 ){            
//             fwrite($f, "Red:0
// Blue:0
// Green:0
// Yellow:0");            
//         }
   
//         fclose($f);
        $listVotes = file('txt/vote.txt');  
        $allCount = countAllVoites();
        foreach ($listVotes as $value): 
            $arrValue = explode(':', $value);             
            if( $arrValue[1] == 0 ){
                $percentVote = 0;
            }
            else{
                $percentVote = round($arrValue[1]*100/$allCount, 1);
            }    
        ?>   
        <span class="nameProgress" style="color: <?= $arrValue[0] ?>"><?= $arrValue[0] ?></span>        
        <div class="progress">
            <div class="progress-bar " 
               role="progressbar" 
               style="width: <?= $percentVote ?>% ; background-color: <?= $arrValue[0]?> !important" 
               aria-valuenow="<?= $percentVote ?>" 
               aria-valuemin="0" 
               aria-valuemax="100">
            </div>
            <p><?= $percentVote ?>%</p>           
        </div>    
        <?php endforeach ?>  
           
    </div>

    <div class="charts2">
            <img src="images-php/barGraph.php" alt="">
    </div>

</section>



<script>
    // let formVote = document.getElementById('formVote');
    // let formButton = document.getElementById('formButton');
    // let charts = document.getElementById('charts');
  
    // charts.style.display = 'none';
    // formVote.style.display = 'block';

    // formVote.addEventListener('submit', ()=>{
    //     event.preventDefault();
    //     charts.style.display = 'block';
    //     formVote.style.display = 'none';
    // });
</script> -->

