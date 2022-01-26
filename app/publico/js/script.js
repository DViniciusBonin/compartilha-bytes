const hamburguer = document.querySelector('.hamburguer');
let menu = document.querySelector('.menu');

hamburguer.onclick = () => {

    if (hamburguer.className.replace('hamburguer ', '') == 'active') {
        hamburguer.className = 'hamburguer';
        menu.className = 'menu';
    } else {
        hamburguer.className = 'hamburguer active';
        menu.className = 'menu active';
    }

}

const input = document.querySelector('.inputfile');

input.addEventListener('change', function (e) {
    const fileName = input.files[0].name;
    document.querySelector('label').innerText = fileName;
});