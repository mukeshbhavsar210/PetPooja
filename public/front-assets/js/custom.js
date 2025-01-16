$(document).ready(function(){    
    $("#related-products").not('.slick-initialized').slick({
        centerMode: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        arrows: true,
        prevArrow:'<i class="icon-left-arrow right-arrow arrow"></i>',
        nextArrow:'<i class="icon-right-arrow left-arrow arrow"></i>',
        responsive: [{
            breakpoint: 1200,
            settings: {
                centerMode: false,
                centerPadding: '0px',
                slidesToShow: 5,
                slidesToScroll: 1,
                
            }
        },{
            breakpoint: 1300,
            settings: {
                 centerMode: false,
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 1200,
            settings: {
                 centerMode: false,
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 1024,
            settings: {
                 centerMode: false,
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 992,
            settings: {
                 centerMode: false,
                slidesToShow: 2,
                slidesToScroll: 1,
            }
        },{
            breakpoint: 576,
            settings: {
                 centerMode: false,
                slidesToShow: 1,
                slidesToScroll: 1,      
            }
        }] 
    });


    //Sticky header
    const header = document.querySelector(".page-header");
    const toggleClass = "is-sticky";

    window.addEventListener("scroll", () => {
    const currentScroll = window.pageYOffset;
    if (currentScroll > 10) {
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