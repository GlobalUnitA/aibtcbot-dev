$(document).ready(function() {
    $('#locale').change(function() {
         window.location.href = $(this).val();
    });
});

//login box hide > show
const introVideo = document.getElementsByClassName("bg-video");
const introWrap = document.querySelector(".login-wrap");
const loginWrap = document.querySelector(".login-box");
const loginlogo = document.querySelector(".loginlogo");

setTimeout(() =>{
    loginlogo.classList.add("show");
}, 500);
setTimeout(() =>{
    loginlogo.classList.remove("show");
    loginlogo.classList.add("hide");
}, 2500);
setTimeout(() =>{
    loginWrap.classList.add("show");
}, 3000);
