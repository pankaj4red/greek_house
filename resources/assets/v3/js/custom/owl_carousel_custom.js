
$('.owl-carousel.simple-carousel').owlCarousel({
    loop: false,
    nav: true,
    navText: [
        "<img class=\"arrow-left-carousel\" src=\"/images/wizard/blue-pre-arrow.png\">",
        "<img class=\"arrow-right-carousel\" src=\"/images/wizard/blue-next-arrow.png\">"
    ],
    navSpeed: 200,
    responsive: {
        0: {
            items: 2,
            slideBy: 2
        },
        576: {
            items: 4,
            slideBy: 4
        },
        992: {
            items: 6,
            slideBy: 6
        }
    }
});

$('.testimonials').owlCarousel({
    items: 1,
    nav: true,
    loop: true
});

