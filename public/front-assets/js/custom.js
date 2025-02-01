$(document).ready(function(){    
    $('.modal-toggle').on('click', function(e) {
        e.preventDefault();
        $('.modal').toggleClass('is-visible');
      });

    //Sticky header
    const body = document.querySelector(".bodyClass");
    const toggleClass = "scrolled";

    window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;
    if (currentScroll > 1) {
        header.classList.add(toggleClass);
    } else {
        header.classList.remove(toggleClass);
    }
    });

});