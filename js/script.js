let body    = document.body;
let prev2   = document.querySelectorAll('.prev2');
let next2   = document.querySelectorAll('.next2');
let window2 = document.querySelectorAll('.window');

// ===============Слайдер============================

for (let i = 0; i < window2.length; i++) {
    let sliderBox = window2[i].firstElementChild;     
    let elemImgs2 = sliderBox.children;   
    // console.log(elemImgs2[1].getAttribute('rel'));
    //Собираем в массив пути картинок 150*150
    let pics = [];
    for (let j = 0; j < elemImgs2.length; j++) {
        pics.push(elemImgs2[j].src);        
    }
    // console.log(pics);

    //Собираем в массив пути оригиналов картинок
    let picsRel = [];
    for (let j = 0; j < elemImgs2.length; j++) {
        picsRel.push(elemImgs2[j].getAttribute('rel'));        
    }
    // console.log(picsRel);

    let count = 0;

    next2[i].addEventListener('click', ()=>{  
        count++;  
        if (count >= pics.length) count = 0;
        for (let k = 0; k < elemImgs2.length; k++) {
            elemImgs2[k].src = pics[(k+count)%pics.length];   
            elemImgs2[k].setAttribute('rel', picsRel[(k+count)%pics.length]);    
        }    
    })
    prev2[i].addEventListener('click', ()=>{
        count--;     
        if (count < 0) count = pics.length;
        for (let m = 0; m < elemImgs2.length; m++) {
            elemImgs2[m].src = pics[(m+count)%pics.length];     
            elemImgs2[m].setAttribute('rel', picsRel[(m+count)%pics.length]);   
        }
    });
}
// ================МОДАЛЬНОЕ ОКНО=================

let allImgs = document.querySelectorAll('.sliderBox>img');;
// console.log(allImgs);

let bgModalWindow = document.createElement('div');   
bgModalWindow.className = 'bgModalWindow'; 

let boxPicture = document.createElement('div');   
boxPicture.className = 'boxPicture'; 

let picture = document.createElement('img');   
picture.className = 'pictureModalWindow';  

for (let i = 0; i < allImgs.length; i++) {
    allImgs[i].addEventListener('click', ()=>{
        // забрать значение атрибута rel
        let rel = allImgs[i].getAttribute('rel');
        // установить это значение элементу big
        picture.setAttribute('src', rel);
        picture.src = allImgs[i].getAttribute('rel');       
    });
}

bgModalWindow.prepend(boxPicture);
boxPicture.prepend(picture);

for (const item of allImgs) {
    item.addEventListener('click', ()=>{
        // console.log(event.target);
        body.prepend(bgModalWindow);
    });
}

picture.addEventListener('click', ()=>{
    bgModalWindow.remove()
    event.cancelBubble = true;
});
// ===============HomeWork 08.11.2020=================
// let formVote = document.getElementById('formVote');
// let formButton = document.getElementById('formButton');
// let sectionVote = document.getElementById('sectionVote');

// console.log(sectionVote);
// sectionVote.style.display = 'none';
// formVote.style.display = 'block';

// formButton.addEventListener('click', ()=>{
//     sectionVote.style.display = 'block';
//     formVote.style.display = 'none';
// });

