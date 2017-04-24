/**
 * Created by Rafał on 2017-03-01.
 */

$(function() {

    $( ".galeria-open" ).click(function() {

       /** altName=$('.galeria-open').attr('alt');  **/

       /** var altName=$('.galeria-open').attr('alt');  **/
       var newitem= $(this).attr('alt');
/**   background-image:url('gallery/1.jpg'); **/

        var altName2= $(".absolute").attr('alt');

/**   background-image:url('gallery/1.jpg'); **/

       
       
      
       $('.absolute').css('background-image', 'url(uploads/photos/'+altName2+'/zdjecia/'+newitem+')'   );

       $('.absolute').css("display", "block" );
    });

    $(".galeria-close").click(function()
    {

        $('.absolute').css("display", "none" );

    });

});
