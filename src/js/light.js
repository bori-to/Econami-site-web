const toggle = document.getElementById('toggleDark');

toggle.addEventListener('click', function(){
    this.classList.toggle('bi-moon');
    if(this.classList.toggle('bi-brightness-high-fill')){
        document.cookie = 'theme=; Max-Age=0';
        location.reload();
    }else{
        document.cookie = "theme=dark";
        location.reload();
    }
});

