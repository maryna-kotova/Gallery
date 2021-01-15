<?php
session_start();
$page = cleanData($_GET['page'] ?? 'home');

//require_once

$action = cleanData($_POST['action'] ?? null); //'sendMessage'
if( !empty($action) ){
    $action();
}
// очистка от пользовательских тегов
// trim — Удаляет пробелы (или другие символы) из начала и конца строки
function cleanData($data){
    return strip_tags(trim( $data ));
}
// отправка письма на почту
function sendMessage(){
    $email   = cleanData($_POST['email']   ?? null);
    $message = cleanData($_POST['message'] ?? null);
    
    if( !$email || !$message ){
        if( !$email ){
            $errors['email'] = 'Email is required';
        }
        if( !$message ){
            $errors['message'] = 'Message is required';
        }
        // $_SESSION['errors'] = 'Invalid from data';
        setMessage('danger', $errors);
    }
    else{
        //отправить почту и написать спасибо
        mail('marynakotova256@gmail.com', 'from my site', "$email \n\r $message");
        setMessage('success','Thanks!');
    }
    redirect('contacts');   
}
// переход на указанную страницу
function redirect($page){
    header('Location: index.php?page='.$page);
    exit(); 
}
// Создаем сообщение об ошибке с указанными параметрами
function setMessage($type, $text){
    $_SESSION['message'] = compact('type', 'text');
    // $_SESSION['message'] = ['type'=>$type, 'text'=>$text];
}
// Показываем сообщение об ошибке
function showMessage($name){
    if( isset($_SESSION[$name] ) ){
        extract($_SESSION[$name]);
        $text = is_array($text) ? implode('<br>', $text) : $text;
        echo "<div class='alert alert-{$type}'> {$text}</div>";
    }
}
// Проверяем завполненщ поле ввода или нет для установки класса is-invalid
function checkInput($nameError){
    return $_SESSION['message']['text'][$nameError] ?? null;
}
// Удаляем сообщение об ошибке
function unsetMessage(){
    if( isset( $_SESSION['message'] ) ){
        unset( $_SESSION['message'] );
    }    
}
//------------------- homework------------------
//устанавливаем имя и значение сессии
function setUserName($nameSess, $email){    
    $_SESSION[$nameSess] = $email;
}

// улучшенная версия функции sendFormSingIn в домашнем задании 5-го урока

//записываем данные входа в сессию
// function sendFormSingIn(){
    //     $entreEmail = cleanData( $_POST['entreEmail'] ?? null );
    //     $password   = cleanData( $_POST['password']   ?? null );
    //     // проверяем заполнены ли данные
    //     if( !$entreEmail || !$password ){

    //         if( !$entreEmail ){
    //             $errorsSingIn['entreEmail'] = 'Email is required!';
    //         }
    //         if( !$password ){
    //             $errorsSingIn['password'] = 'Password is required!';
    //         } 
    //         //если есть ошибки, выводим сообщение об ошибках
    //         setMessage('danger', $errorsSingIn );
    //         redirect('singin');        
    //     }
    //     else{              
    //         // если запонены тогда записываем в сессию значения
    //         setUserName('user', $entreEmail); 
    //         //переходим сразу после входа на главную страницу
    //         redirect( 'home' ); 
    //         // print_r($entreEmail); 
    //     }    
// }

// улучшенная версия функции sendFormSingUp в домашнем задании 5-го урока

//записываем данные регистрации в сессию
// function sendFormSingUp(){
    //     $newEmail    = cleanData( $_POST['newEmail']    ?? null );
    //     $newpassword = cleanData( $_POST['newpassword'] ?? null );
    //     $repass      = cleanData( $_POST['repass']      ?? null );    
    //     if( !$newEmail || !$newpassword || !$repass ){
    //         // проверяем заполнены ли данные
    //         if( !$newEmail ){
    //             $errorsSingUp['newEmail'] = 'Email is required!';
    //         }                
    //         if( strlen($newpassword) < 6 ){
    //             $errorsSingUp['newpassword'] = 'Password too short';
    //         }       
    //         if( !$repass || $repass != $newpassword ){
    //             $errorsSingUp['repass'] = 'Passwords do not match!';           
    //         }
    //         //если есть ошибки, выводим сообщение об ошибках
    //         setMessage('danger', $errorsSingUp );
    //         redirect('singup'); 
    //     }
    //     else{ 
    //         // если запонены тогда записываем в сессию значения
    //         setUserName('user', $newEmail);         
    //         //переходим сразу после входа на главную страницу
    //         redirect( 'home' ); 
    //     }    
// }

// действие кнопки выхода
function exitUser(){
    //удалить сессию user
    // $_SESSION['user'] = '';
    session_destroy();
    // перейти на главную страницу
    redirect( 'home' );  
}

//--------------------- lesson 4-=-----------------
function dump($arr){
   echo '<pre>' . print_r($arr, true) . '</pre>';
}

function makeDir($path){
    if( !file_exists($path) ){
        mkdir($path);
    }
}

function uploadFile(){
    $file = $_FILES['file'];
    // dump($file);
    //     Array
    // (
    //     [name] => 13d9c28cd1388a19578e8193fce0bb04.jpg
    //     [type] => image/jpeg
    //     [tmp_name] => W:\userdata\php_upload\phpC769.tmp
    //     [error] => 0
    //     [size] => 80236
    // )

    if( $file['error']!=0 ){
        if( $file['error'] == 4 ){
            setMessage('danger', 'File is Required!');
        }
        elseif( $file['error'] == 1 ){
            setMessage('danger', 'File is too big!');
        }
        elseif( $file['error'] == 2 ){
            setMessage('danger', 'File is big!');
        }
    }
    else{
        $typeFiles = ['image/gif', 'image/jpeg', 'image/png', 'image/webp'];
        if( $file['size'] > 1024*1024*100000000 ){
            setMessage('danger', 'File is big!');
        }
        elseif( !in_array($file['type'], $typeFiles) ){
            setMessage('danger', 'File must been image!');
        }
        else{
            makeDir('images');
            $fName = time() . '_' . $file['name']; //1604136001_bg.ipg 
            move_uploaded_file($file['tmp_name'], 'images/' . $fName); 
            resizeImage($fName, 'images', $file['type']);
            setMessage('success', 'File upload!');
        }        
    }       
    redirect('uploads'); 
}

function resizeImage($fName, $dir, $type){
    $f = $dir . '/' .  $fName; //images/lis.jpg  
    $type = explode('/', $type)[1];  
    $imagecreate = 'imagecreatefrom' . $type;
    $src = $imagecreate($f); // создаем изображение на основе загруженого файла
    $width_src = imagesx($src); //ширина исходного изображения
    $height_src = imagesy($src); //высота исходного изображения

    //Создание квадратного изображения
    $size = 100; //ширина и высота изображения
    $dest = imagecreatetruecolor($size, $size); //
    if( $width_src > $height_src ){
        imagecopyresized($dest, $src, 0, 0, ($width_src - $height_src)/2, 0, $size, $size, $height_src, $height_src );
    }
    else{
        imagecopyresized($dest, $src, 0, 0, 0, ($height_src - $width_src)/2, $size, $size, $width_src, $width_src);
    }
    $imagesave = 'image' . $type;
    $imagesave($dest, "{$dir}/{$size}x{$size}_{$fName}");
    imagedestroy($dest);
    
    //Создание уменьшеного изображения
    $width_dest  = 200;
    // 1000 * 500
    // 200  * x
    $height_dest = $width_dest * $height_src / $width_src;
    $dest = imagecreatetruecolor($width_dest, $height_dest);
    imagecopyresized($dest, $src, 0, 0, 0, 0, $width_dest, $height_dest, $width_src, $height_src);

    $imagesave($dest, "{$dir}/{$width_dest}_{$fName}");
    imagedestroy($dest);
    imagedestroy($src);
}
// ===================Homework===================================

//создаем папку для картинок слайдера
function newSlider(){
    //считываем текст, который ввел пользователь
    $sliderName = cleanData($_POST['sliderName'] ?? null);
    $d=opendir('sliders');  
    while(($entry=readdir($d))!==false){ 
        if ($entry == $sliderName){ 
            setMessage('danger', 'This name already exists!');  
            redirect('managesliders');           
        } 
        $entry = false;
    } 
    closedir($d);    

    if( !$sliderName ){
        setMessage('danger', 'Empty form!');
    }
    else{       
        // создаем папку с названием, которое ввел пользователь
        makeDir('sliders/'.$sliderName);
        setMessage('success', 'You created new slider!');
        
    }
    redirect('managesliders'); 
}

function resizeImageForSlider($fName, $dir, $type){
    //Путь к картинке, которую нужно изменить
    $f = $dir . '/' .  $fName; //images/lis.jpg  
    //Перезаписываем тип файла, оставляя только расширение
    $type = explode('/', $type)[1];  
    //Создаюм функцию для соответвующего расширения
    $imagecreate = 'imagecreatefrom' . $type;
    $src = $imagecreate($f); // создаем изображение на основе загруженого файла
    $width_src = imagesx($src); //ширина исходного изображения
    $height_src = imagesy($src); //высота исходного изображения

    //Создание квадратного изображения
    $size = 150; //ширина и высота изображения
    $dest = imagecreatetruecolor($size, $size); //Создаем новое полноцветное изображение
    if( $width_src > $height_src ){// Если картинка горизонтаной ориентации
        //Копирование и изменение размера части изображения
        imagecopyresized($dest, $src, 0, 0, ($width_src - $height_src)/2, 0, $size, $size, $height_src, $height_src );
    }
    else{// Если картинка вертикальной ориентации
        imagecopyresized($dest, $src, 0, 0, 0, ($height_src - $width_src)/2, $size, $size, $width_src, $width_src);
    }
    //Создаем функцию, которая выводит изображение в браузер или пишет в файл
    $imagesave = 'image' . $type;
    //1. imagecreatetruecolor(). 2. Путь для сохранения файла
    $imagesave($dest, "{$dir}/small_{$fName}");
    // Уничтожение изображения;освобождает память, занятую изображением $dest
    imagedestroy($dest);

    //Создание уменьшеного изображения
    $width_dest  = 50;
    // 1000 * 500
    // 200  * x
    $height_dest = $width_dest * $height_src / $width_src;
    $dest = imagecreatetruecolor($width_dest, $height_dest);
    imagecopyresized($dest, $src, 0, 0, 0, 0, $width_dest, $height_dest, $width_src, $height_src);

    $imagesave($dest, "{$dir}/mini_{$fName}");
    imagedestroy($dest);
    imagedestroy($src);
}

//Загружаем картинки в выбранную папку
function uploadNewImage(){
    //Массив данных загружаемого файла
    $file = $_FILES['yourImages']; 
    // dump(count($file['name'])); 
    //Запрашиваем название выбранной папки
    $mySliders =  strip_tags($_POST['mySliders'] ?? null);
    //Проверяем сделан ли выбор папки
    if( $mySliders == 'choose' ){
        //Если папка не выбрана, тогда ошибка
        setMessage('danger', 'No slider selected!');
    }   
    else{
        for ($i=0; $i < count($file['name']); $i++) { //для мультизагрузки - обрабатываем каждый файл
            // dump($file);             
        //Делаем проверки загружаемого файла
            if( $file['error'][$i]!=0 ){
                //Если файл не был загружен
                if( $file['error'][$i] == 4 ){
                    setMessage('danger', 'File is Required!');
                }
                //Если размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini
                elseif( $file['error'][$i] == 1 ){
                    setMessage('danger', 'File is too big!');
                }
                //Если размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.
                elseif( $file['error'][$i] == 2 ){
                    setMessage('danger', 'File is big!');
                }
            }
            else{
                //Записываем в массив типы/расширения файлов, которые разрешено загружать
                $typeFiles = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                //Устанавливаем допустимый размер файла в байтах
                if( $file['size'][$i] > 1024*1024*100000000 ){
                    setMessage('danger', 'File is big!');
                }
                //Сравниваем тип загруженого файла с разрешенным
                elseif( !in_array($file['type'][$i], $typeFiles) ){
                    setMessage('danger', 'File must been image!');
                }
                //Если всё впорядке, то загружаем наш файл
                else{   
                    //Приваеваем оригиналу файла имя с приставкой         
                    $fName = $mySliders . '-' . $file['name'][$i]; //1604136001_bg.ipg 
                    //Перемещаем загруженный файл в новое место
                    //1.Путь к загруженному файлу
                    //2.Путь, по которому необходимо переместить файл.
                    move_uploaded_file($file['tmp_name'][$i], 'sliders/'. $mySliders . '/' . $fName); 
                    //Также  добавляем уменьшенное изображение на основе загруженного
                    resizeImageForSlider($fName, 'sliders/'.$mySliders, $file['type'][$i]);
                    // Создаем сообщение что файл загружен
                    setMessage('success', 'File upload!');
                }        
            }  
        }           
    }
    redirect('managesliders'); 
}

function dirDel($dir){ 
    $d=opendir($dir);  
    while(($entry=readdir($d))!==false){ 
        if ($entry != "." && $entry != ".."){ 
            if (is_dir($dir."/".$entry)){  
                dirDel($dir."/".$entry);  
            } 
            else{  
                unlink ($dir."/".$entry);  
            } 
        } 
    } 
    closedir($d);  
    rmdir ($dir);  
 }

function removeSlider(){
    //Запрашиваем название выбранной папки
    $allSliders = strip_tags($_POST['allSliders'] ?? null);     
    //Проверяем сделан ли выбор папки
    if( $allSliders == 'choose' ){
        //Если папка не выбрана, тогда ошибка
        setMessage('danger', 'No slider selected!');
    } 
    else{
        $path = $_SERVER['DOCUMENT_ROOT'] . '/sliders/'.$allSliders;
        dirDel($path);  
        setMessage('success', 'File delete!');
    }
    redirect('managesliders');    
}
// =================lesson 5=====_08.11.2020_=============

function saveReview(){
    $name    = cleanData($_POST['name']    ?? null);
    $review  = cleanData($_POST['review']  ?? null);
    $captcha = cleanData($_POST['captcha'] ?? null);
    $time = time();

    if( !$name || !$review ){
        setMessage('danger', 'All fields required!');
    } 
    elseif($captcha != $_SESSION['captcha']){
        setMessage('danger', 'Captcha is invalid!');
    }
    else{
        $f = fopen('txt/reviews.txt', 'a');
        fwrite($f, "$name|$review|$time\r\n");
        fclose($f);
        setMessage('success', 'Review sent!');
    }
    redirect('reviews');
}
function showReview(){
    // $html = file_get_contents('http://google.com');// выводим страничку с содержимым
    // ----------------------------------------------
    // $f = fopen('reviews.txt', 'r');
    // if($f){
    //     $html = '';
    //     while(!feof($f)){// считывает посимвольно до конца файло, пока не будет false
    //         $html .= fgetc($f);            
    //     }  
    //     echo $html;      
    // }
    // fclose($f);
    // ------------------------
    //
    $lines = file('txt/reviews.txt');
    // переворачиваем массив, чтоб последние отзывы были первыми
    $lines = array_reverse($lines);
    // dump($lines);
    // foreach ($lines as $line) {
    //     list($name, $review, $time) = explode('|', $line);
    //     $date = date('d-m-Y H:i' , trim($time));// обираем пробелы в виде \r\n
    //     echo '<div class="border p-3 m-3">';
    //     echo "{$name} | $date <hr><bloquote>$review</bloquote>";
    //     echo '</div>';
    // }
    //количество отзывов на странице
    $perPage = 2;
    //Количестсво страниц в зависимости от кол-ва отзывов
    $totalPages = ceil(count($lines) / $perPage);
    $p = $_GET['p'] ?? 0;

    for ($i = $p*$perPage; ($i < $p * $perPage + $perPage) && $i < count($lines); $i++) {       
        list($name, $review, $time) = explode('|', $lines[$i]);
        $date = date('d-m-Y H:i' , trim($time));// обираем пробелы в виде \r\n
        echo '<div class="border p-3 m-3">';
        echo "{$name} | $date <hr><bloquote>$review</bloquote>";
        echo '</div>';
    }
    //Пагинация - страницы
    echo '<nav><ul class="pagination">';
    for ($i=0; $i < $totalPages; $i++) { 
        echo "<li class='page-item " . ($p==$i ? 'active' : '') . "'><a class='page-link' href='index.php?page=reviews&p={$i}'>".($i+1)."</a></li>";      
    }
    echo '</ul></nav>';
}
// ================ HomeWork 08.11.2020 ==========================
function saveLoginPass($name, $pass){   
    $userDataFile = fopen('txt/user-data.txt', 'a');
    fwrite($userDataFile, "$name|$pass\r\n");
    fclose($userDataFile);  
}
function sendFormSingUp(){
    $newEmail    = cleanData( $_POST['newEmail']    ?? null );
    $newpassword = cleanData( $_POST['newpassword'] ?? null );
    $repass      = cleanData( $_POST['repass']      ?? null );    
   
    if( !$newEmail ){
        $errorsSingUp['newEmail'] = 'Email is required!';
        setMessage('danger', $errorsSingUp );
        redirect('singup'); 
    }                
    elseif( strlen($newpassword) < 6 ){
        $errorsSingUp['newpassword'] = 'Password too short';
        setMessage('danger', $errorsSingUp );
        redirect('singup'); 
    }       
    elseif( !$repass || $repass != $newpassword ){
        $errorsSingUp['repass'] = 'Passwords do not match!';  
        setMessage('danger', $errorsSingUp );
        redirect('singup');          
    }   
    else{ 
        //сохраняем данные пользователя для дальнейшего входа на сайт
        saveLoginPass($newEmail, $newpassword);
        //записываем в сессию значения
        setUserName('user', $newEmail);              
        //переходим сразу после входа на главную страницу
        redirect( 'home' ); 
    }    
}

function sendFormSingIn(){
    $entreEmail = cleanData( $_POST['entreEmail'] ?? null );
    $password   = cleanData( $_POST['password']   ?? null );
    //массив записанных данных регистрации
    $acounts = file('txt/user-data.txt');
    //Создаем переменные,в которые запишем проверочное слово при полном совпадении
    //.. заполенных данных пользователем с массивом 
    $checkEmail = '';
    $checkPass = '';    
    //Перебираем массив всех существующих данных
    foreach ($acounts as $acount) {   
        //Разбираем строку данных каждого пользователя на массив     
        $arrAcount = explode('|', $acount);  
        // dump($arrAcount) ;  
        //Если есть точное совпадение с емейлом       
        if($arrAcount[0] == $entreEmail){
            $checkEmail = 'goodEmail';
            //если и пароль совпадает этого же емейла            
            if($arrAcount[1] == $password){                
                $checkPass = 'goodPass';
            } 
        }                      
    }   
    // проверяем заполнены ли данные
    if( !$entreEmail || !$password ){

        if( !$entreEmail ){
            $errorsSingIn['entreEmail'] = 'Email is required!';
        }
        if( !$password ){
            $errorsSingIn['password'] = 'Password is required!';
        } 
        //если есть ошибки, выводим сообщение об ошибках
        setMessage('danger', $errorsSingIn );
        redirect('singin');        
    }   
    //если есть хоть одно не совпадение , тогда ошибка 
    elseif( $checkEmail != 'goodEmail' || $checkPass != 'goodPass') {
        setMessage('danger', 'Wrong name or password!');        
        redirect('singin');
    }       
    else{              
        // если всё правильно записываем в сессию значения
        setUserName('user', $entreEmail); 
        //переходим сразу после входа на главную страницу
        redirect( 'home' ); 
        // print_r($entreEmail); 
    }    
}
function sendVote(){
    $vote = cleanData( $_POST['vote'] ?? null );  
    
    $listVotes = file('txt/vote.txt');  
    $userVote = fopen('txt/vote.txt', 'w+');     
    foreach ($listVotes as $listVote) {             
        $arrlistVote = explode(':', $listVote);         
        if($arrlistVote[0] == $vote){                     
            $arrlistVote[1] = 1*(trim($arrlistVote[1])) + 1;                        
        }
        else{
            $arrlistVote[1] = 0 + trim($arrlistVote[1]);
        }
        fwrite($userVote, "$arrlistVote[0]:$arrlistVote[1]\r\n");
    } 
    fclose($userVote); 
    // redirect('home');    
}

function countAllVoites(){
    $listVotes = file('txt/vote.txt'); 
    $count = 0;
    foreach ($listVotes as $listVote) {  
        $arrlistVote = explode(':', $listVote); 
        $count += 1*(trim($arrlistVote[1])); 
    }
    return $count;
}

function getArrCountVotes(){
    $arrCountVotes =[];
    $listVotes = file('txt/vote.txt'); 
    foreach ($listVotes as $listVote) { 
        $arrlistVote = explode(':', $listVote);  
        array_push($arrCountVotes, trim($arrlistVote[1]));
    } 
    // dump($arrCountVotes);
    return $arrCountVotes;
}





















