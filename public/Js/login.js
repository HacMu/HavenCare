let login_inp3= document.querySelector('#password-3');
let toggle_btn3= document.querySelector('#toggle_btn-3');

toggle_btn3.addEventListener('click',()=>{
    if(login_inp3.type === 'password'){
        login_inp3.setAttribute('type','text');
        toggle_btn3.classList.add('hide');
    }
    else{
        login_inp3.setAttribute('type','password');
        toggle_btn3.classList.remove('hide');
    }
})


login__btn.addEventListener('click',()=>{
    alert("حاج راس الدحبر");
    console.log("hi");
})