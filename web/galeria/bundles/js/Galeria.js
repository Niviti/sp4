/**
 * Created by Rafał on 2017-03-01.
 */
$(function() {

var licznik = document.getElementById("text").innerHTML;

var a = window.innerWidth;

if(a<500)
{
$("a").removeClass("overlay title galeria-open");

$("img").css('margin-top', '10px');

}


$( ".galeria-open" ).click(function() {
      

       $('._3ixn').css("background", 'rgba(0,0,0,0.7)');

        $('._3ixn').css("display", 'block');


     // var newitem= $(this).attr('alt');     

      var newitem2= $(this).attr('name');

      // Tutaj manipulujemy wartościami id 1,2,3,4,5
      var youtubeimgsrc = document.getElementById(newitem2).src;
    
      var x=youtubeimgsrc.replace("http://localhost:8000/galeria/", " ");

     $('.absolute').css("background-image", 'url('+x+')'   );

     $('.absolute').css("display", "block" );
   

       jQuery('.switch-left').click(function(){
         newitem2--;
         if(newitem2>=0)
         {
         var youtubeimgsrc = document.getElementById(newitem2).src;
         var x=youtubeimgsrc.replace("http://localhost:8000/galeria/", " ");
        
          $('.absolute').css("background-image", 'url('+x+')'   );

          $('.absolute').css("display", "block" );
        }
        else
        {
          newitem2=licznik;

         var youtubeimgsrc = document.getElementById(newitem2).src;
         var x=youtubeimgsrc.replace("http://localhost:8000/galeria/", " ");
         
         $('.absolute').css("background-image", 'url('+x+')'   );

         $('.absolute').css("display", "block" );
        }
      });


        jQuery('.switch-right').click(function(){
         newitem2++;
         if(newitem2<=licznik)
         {
         var youtubeimgsrc = document.getElementById(newitem2).src;
         var x=youtubeimgsrc.replace("http://localhost:8000/galeria/", " ");
         
         $('.absolute').css("background-image", 'url('+x+')'   );

         $('.absolute').css("display", "block" );
       }
       else
       {
         newitem2=0;
         var youtubeimgsrc = document.getElementById(newitem2).src;
         var x=youtubeimgsrc.replace("http://localhost:8000/galeria/", " ");
         
         $('.absolute').css("background-image", 'url('+x+')'   );

         $('.absolute').css("display", "block" );
       }
     });



    });


    $(".galeria-close").click(function()
    {
        $('.absolute').css("display", "none" );

           $('._3ixn').css("display", 'none');

    });


});
