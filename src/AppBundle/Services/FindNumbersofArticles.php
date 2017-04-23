<?php

namespace AppBundle\Services;

use AppBundle\Repository\FindMonth;
use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use mysqli;

class FindNumbersofArticles 
{
 public function findNumbersofArticles()
 {
 	    $host = "localhost";
	    $db_user = "root";
	    $db_password = "";
	    $db_name = "sp4";
 
    	try 
		{
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
			
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				  //Czy email już istnieje?
				  $notes = $polaczenie->query("SELECT * FROM article");
		    }
        } 
        catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}

        $tablica=array();


        $length = count($notes);

        $licznik1=0;
        $licznik2=0;
        $id=1;

    while($id<13)
    {
        for ($i=0 ; $i< $length;$i++)
        {
            if($notes[$i]->ReturnMonth() == $id ) {
                    $licznik++;
            }
        }
           $tablica[licznik2]= $licznik;
           $licznik=0;
           $licznik2++;
    }

     
  return $tablica;
 }
}














?>