/**
 * Created by Rafał on 2017-02-21.
 */
function Wysuń2()
{
    $("#FaceBook").animate({width: "300px"},500, "swing")

    $("#formularzX").animate({width: "300px"},500, "swing")



    $("#Logo1").animate({marginRight: "300px"},500, "swing")



    $("#Logo2").animate({marginRight: "300px"},500, "swing")

    var nowy1= document.getElementById('fb_zawartosc');
    nowy1.style.display="block";
}


function Wsuń2()
{
    $("#FaceBook").animate({width: "0px"},500, "swing")

    $("#formularzX").animate({width: "-0px"},500, "swing")

//$("#formularz").animate({marginRight: "-=320px"},500, "linear")

//$("#Logo1").animate({Right: "-=300px"},500, "linear")

//$("#Logo2").animate({Right: "-=300px"},500, "linear")

    $("#Logo1").animate({marginRight: "-0px"},500, "swing")

    $("#Logo2").animate({marginRight: "-0px"},500, "swing")

    var nowy2= document.getElementById('fb_zawartosc');

    nowy2.style.display="none";

}

function Wyskocz3()
{
    var x = document.getElementById("Logo2");
    var y = document.getElementById("Logo1");
    x.style.display="block";
    y.style.display="none";
}



// mechaniz 2 guzików jeden się pojawia a drugi znika
function Wyskocz4()
{
    var x = document.getElementById("Logo2");
    var y = document.getElementById("Logo1");
    x.style.display="none";
    y.style.display="block";
}


function Zaladuj1()
{


    var box3= document.getElementById("Logo1");


//var boxD= document.getElementById("wiadomosc");


    box3.addEventListener("click",Wysuń2,true);
    box3.addEventListener("click",Wyskocz3,true);
//boxD.addEventListener("onkeyup",Licz,true);
}

function Verify()
{

    var nick = document.forms['wiadomosc'].nick.value;
    var content = document.forms['name'].content.value;
    var error = false;

    if (nick == "")
    {
        document.forms['wiadomosc'].nick.style.border = "2px solid #FF0000";
        alert('Nie wypełniłeś pola z wiadomością!');
        error = true;
    }
    if(error)
    {
        return false ;
    }



}




function Zaladuj2()
{

    var box4= document.getElementById("Logo2");

    box4.addEventListener("click",Wsuń2,true);

    box4.addEventListener("click",Wyskocz4,true);
}

function Zaladuj3()
{

    var box4= document.getElementById("submit");

    box4.addEventListener("click",Verify,true);

}

window.addEventListener("load", Zaladuj2, true);
window.addEventListener("load", Zaladuj1, true);
window.addEventListener("load", Zaladuj3, true);
