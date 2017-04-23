<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Repository\FindMonth;
use AppBundle\Entity\Article;


class ContentController extends Controller
{
    /**
     * @Route("/article", name="article")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')
            ->findAll();
        $article_length = count($articles);
        $article_new=array();

        $j=0;

        for($i =0; $i < $article_length ; $i++)
        {
            $number = $article_length-4;
            if($i>$number)
            {

                $article_new[$j] = $articles[$i];
                $j++;
            }
        }
        $reversed = array_reverse($article_new);

        return $this->render('default/article.html.twig', array(
              'article_new' => $reversed
        ));
    }

    /**
     * @Route("/article/{xx}", name="article_next")
     */
    public function articleNextAction(Request $request, $xx)
    {
   
       $em= $this->getDoctrine()->getManager();
   
        
       $notes= $em->getRepository('AppBundle:Article')
          ->findAll();
   
        $tablica=array();
        $length = count($notes);
        $licznik1=0;
        $licznik2=0;
        $id=1;
    while($id<13)
    {
        for ($i=0 ; $i<$length;$i++)
        {
            if($notes[$i]->ReturnMonth() == $id ) 
            {
                    $licznik1++;
            }
        }
        ini_set('memory_limit', '-1');
           $tablica[$licznik2]=$licznik1;
           $licznik1=0;
           $licznik2++;
           $id++;
    }
        $note = $em->getRepository('AppBundle:Article')
            ->findOneBy([
                'id' => $xx
            ]);

        $daty = $note->ReturnMonth() ;

        return $this->render('default/article_next.html.twig', array(
            'article' => $note,
             'daty' => $daty,
             'tablica' =>$tablica
        ));
    }

    /**
     * @Route("/article/archives/{xx}", name="archives")
     */
    public function Archives($xx)
    {
        $em= $this->getDoctrine()->getManager();

        $notes = $em->getRepository('AppBundle:Article')
            ->findAll();

        $length = count($notes);

        $article_new=array();
        $licznik =0;
         
        for ($i=0 ; $i< $length;$i++)
        {
            if($notes[$i]->ReturnMonth() == $xx ) {
                    $article_new[$licznik]= $notes[$i];
                    $licznik++;
            }
        }

        return $this->render('default/archives.html.twig', array(
            'wpisy' => $article_new
        ));
    }

}