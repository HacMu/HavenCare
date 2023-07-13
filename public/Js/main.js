let features_title = document.querySelector('#features_title');
let AboutUs_title= document.querySelector('#AboutUs_title');

window.onscroll = () => {
    $value = scrollY;
    if ($value > 500) {
        features_title.classList.add('AnimatToRight');
    } else {
        features_title.classList.remove('AnimatToRight'); 
    }
    if ($value > 1861.25) {
        AboutUs_title.classList.add('AnimatToRight');
    }else{
        AboutUs_title.classList.remove('AnimatToRight');
    }

}
