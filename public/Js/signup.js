let login_inp1= document.querySelector('#password');
let login_inp2= document.querySelector('#Reppassword');


let toggle_btn1= document.querySelector('#toggle_btn-1');
let toggle_btn2= document.querySelector('#toggle_btn-2');


let login__btn= document.querySelector('#login__btn');

let Cont__btn= document.querySelector('#Cont__btn');
let signup_normal= document.querySelector('#signup_normal');
let signup_cont= document.querySelector('#signup_cont');


Cont__btn.addEventListener('click',()=>{
    signup_normal.style.display = "none";
    signup_cont.style.display = "inline-block";
})

toggle_btn1.addEventListener('click',()=>{
    if(login_inp1.type === 'password'){
        login_inp1.setAttribute('type','text');
        toggle_btn1.classList.add('hide');
    }
    else{
        login_inp1.setAttribute('type','password');
        toggle_btn1.classList.remove('hide');
    }
})

toggle_btn2.addEventListener('click',()=>{
    if(login_inp2.type === 'password'){
        login_inp2.setAttribute('type','text');
        toggle_btn2.classList.add('hide');
    }
    else{
        login_inp2.setAttribute('type','password');
        toggle_btn2.classList.remove('hide');
    }
})
