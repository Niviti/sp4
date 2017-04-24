/**
 * Created by Rafał on 2017-02-10.
 */

$(function() {

    //settings for slider
    var width = 720;
    var animationSpeed = 1000;
    var pause = 3000;
    var currentSlide = 1;
    var licznik = 1 ;
    //cache DOM elements
    var $slider = $('#slider');
    var $slideContainer = $('.slides', $slider);
    var $slides = $('.slide', $slider);

    var interval;

    var a = window.innerWidth;
    var c=a*8.5 ;
    var y= a*3 ;
    $('.slides').css("width", c );
    $('.slides').css('margin-left', -y );
    $('#slider').css("width", a );
    $('.slide').css("width", a);


    function startSlider()
    {
        $slideContainer.animate({'margin-left': '-='+a}, animationSpeed, function() {
            if (++currentSlide === 4) {
                currentSlide = 1;
                $slideContainer.css('margin-left', -y);
            }
        });
    }

    function startSlider2()
    {
        $slideContainer.animate({'margin-left': '+='+a}, animationSpeed, function() {
            if (--currentSlide === -2) {
                currentSlide = 1;
                $slideContainer.css('margin-left', -y);
            }
        });
    }

    function pauseSlider() {
        clearInterval(interval);
    }



    $( ".right" ).click(function() {
        startSlider();
        licznik++;
        if(licznik==4)
        {
            licznik=1
        }
        $('.value').html( licznik +"/3" );
    });

    $( ".left" ).click(function() {
        startSlider2();
        licznik--;
        if(licznik==0)
        {
            licznik=3;
        }
        $('.value').html( licznik +"/3" );
    });
    /**
     alert(window.innerWidth);
     var a = window.innerWidth;
     $("#block").css("background-color", "yellow");
     $('#block').css("width", a );
     **/
});


