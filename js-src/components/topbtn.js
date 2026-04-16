const btnTop = document.querySelector('.topbtn');
if(btnTop) {
  btnTop.addEventListener("click", () => {
    window.scroll({
      top: 0,
      behavior: 'smooth'
    });
  });
}
