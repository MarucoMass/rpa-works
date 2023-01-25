// header
const hamburguer = document.querySelector('.header .header__section .nav-burguer');
const navigation = document.querySelector('.header .header__section .header__nav');
const item = document.querySelectorAll('.header .header__section .header__nav .header__list .header__item a');

hamburguer.addEventListener('click', ()=>{
    hamburguer.classList.toggle('active');
    navigation.classList.toggle('active');
})

item.forEach(selectItem => selectItem.addEventListener('click', ()=>{
    if ((navigation.classList = 'active') && (hamburguer.classList = 'active')) {
        hamburguer.classList = 'nav-burguer';
        navigation.classList = 'header__nav';     
    }
}))

window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    header.classList.toggle('active', window.scrollY > 0);
})