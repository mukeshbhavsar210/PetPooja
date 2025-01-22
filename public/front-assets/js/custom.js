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

    //Sticky Progress Step
    const progressStep = document.querySelector(".finalStep");
    const progressStepFooter = document.querySelector("footer");
    const progressToggle = "is-sticky";
    const progressToggleFooter = "is-sticky";

    window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;
    if (currentScroll > 950) {
        progressStep.classList.add(progressToggle);
        progressStepFooter.classList.add(progressToggleFooter);
    } else {
        progressStep.classList.remove(progressToggle);
        progressStepFooter.classList.remove(progressToggleFooter);
    }
    });

});