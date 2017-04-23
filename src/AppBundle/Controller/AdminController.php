<?php

namespace AppBundle\Controller;

use AppBundle\Forms\galleryForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File;
use AppBundle\Forms\ArticleForm;
use AppBundle\Forms\photosForm;
use AppBundle\Entity\Article;
use AppBundle\functions\Functions;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Entity\photo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\user; 
use AppBundle\Forms\UserForm; 
use ZipArchive;

class AdminController extends Controller
{

    /**
     * @Route("/admin", name="admin")
     */
    public function RenderAdmin()
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * var_dump
     * @Route("/admin/article/creat", name="article-creat")
     */
    public function CreateArticle(Request $request)
    {
        $Article = new Article();

        $form = $this->createForm(ArticleForm::class, $Article);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $file = $Article->getPicture();

            $em = $this->getDoctrine()->getManager();
            $zapytanieX = $em->getRepository('AppBundle:Article')
                ->findAll();
            $ilosc_wierszy = count($zapytanieX);
            $fileName =  $ilosc_wierszy+1 ;
            $fileName2 =  "$fileName.jpg";
            $file->move(
                $this->getParameter('picture_directory'),
                $fileName
            );

            $Article->setPicture($fileName);
            $Article = $form->getData();
            $Article->setDate(new \DateTime('now'));
            $em->persist($Article);
            $em->flush();

            $this->addFlash('success',
                sprintf('Udało się stowrzyć artykuł !')
            );

            return $this->redirectToRoute('admin');
        }
        $dir = '%kernel.root_dir%/../galeria/uploads/photos/';  

        $opcje = scandir($dir);
        unset($opcje[0]);
        unset($opcje[1]);
        sort($opcje);
        if($opcje==null)
        {
           $opcje[0] = '1.jpg';
        }

        $length= count($opcje)-1;

        return $this->render('admin/article-creat.html.twig', [
            'ArticleForm' => $form->createView(),
            'opcje' => $opcje,
            'length' => $length
        ]);
    }

    /**
     * @Route("/admin/article", name="articles")
     */
    public function Articles()
    {
        $em = $this->getDoctrine()->getManager();

        $articles=  $em ->getRepository('AppBundle:Article')->findAll();

        return $this->render('admin/article.html.twig', array(
            'articles' =>  $articles
        ));
    }

    /**
     * @Route("/admin/article/edit/{id}", name="article-edit")
     */
    public function EditArticle(Request $request, Article $Article)
    {
        $form = $this->createForm(ArticleForm::class, $Article);
        $form->handleRequest($request);

        $dir = '%kernel.root_dir%/../galeria/uploads/photos/';  

        $opcje = scandir($dir);

        unset($opcje[0]);
        unset($opcje[1]);
        sort($opcje);

        if($opcje==null)
        {
           $opcje[0] = '1.jpg';
        }

        $length= count($opcje)-1;

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $Article->getPicture();
            $em = $this->getDoctrine()->getManager();
            $zapytanieX = $em->getRepository('AppBundle:Article')
                ->findAll();
            $ilosc_wierszy = count($zapytanieX);
            $fileName =  $ilosc_wierszy+1 ;
            $fileName2 =  "$fileName.jpg";
            $file->move(
                $this->getParameter('picture_directory'),
                $fileName2
            );
            $Article->setPicture($fileName2);
            $Article = $form->getData();

            $em->persist($Article);
            $em->flush();

            $this->addFlash('success',
                sprintf('Udało się edytować artykuł !')
            );

            return $this->redirectToRoute('articles');
        }

        return $this->render('admin/article-edit.html.twig', [
            'ArticleForm' => $form->createView(),
            'opcje' => $opcje,
            'length' => $length
        ]);

    }

    /**
     * @Route("/admin/article/delete/{id}", name="article_delete")
     */
    public function CancelArticle($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:Article')
            ->findOneBy([
                'id' => $id
            ]);

        $this->addFlash('success',
            sprintf('Udało się usunąć artykuł !')
        );

        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('articles');
    }

    /**
     * @Route("/admin/gallery-creat", name="open-source")
     */
    public function CreatGallery(Request $request)
    {

        $photo = new photo();

        $form = $this->createForm(galleryForm::class, $photo);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $file = $photo->getphoto();

            $em = $this->getDoctrine()->getManager();
            $zapytanieX = $em->getRepository('AppBundle:photo')
                ->findAll();
            $ilosc_wierszy = count($zapytanieX);
            $fileName =  $ilosc_wierszy+1 ;
            $fileName2 =  "$fileName.jpg";
            
            $file->move(
                $this->getParameter('picture_directory2'),
                $fileName2
            );
                
               $var = $form->get('name')->getData();

           $photo->setphoto($fileName2);
        
           $photo = $form->getData();

           $fs = new Filesystem();
      
      try {
$fs->mkdir('%kernel.root_dir%/../galeria/uploads/photos/'. $var.'/zdjecia');
} catch (IOExceptionInterface $e) {
    echo "An error occurred while creating your directory at ".$e->getPath();
}

            $em->persist($photo);
            $em->flush();

            $this->addFlash('success',
                sprintf('Udało się dodać Galerie !')
            );

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/gallery-creat.html.twig', [
            'galleryForm' => $form->createView()
        ]);

    }

     /**
     * @Route("/admin/gallery-admin", name="gallery-admin")
     */
    public function CreatGalleryAdmin()
    {
           $em=$this->getDoctrine()->getManager();
           $galeria=$em->getRepository('AppBundle:photo')->findAll();
          
    return $this->render('admin/gallery-admin.html.twig', array(
              'Galeria' => $galeria
    ));
    }

    /**
     * @Route("/admin/gallery-admin/edit/{id}", name="gallery-Edit")
     */
    public function EditGalleryAdmin(Request $request, photo $photo)
    {

        $form = $this->createForm(galleryForm::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $photo->getphoto();

            $em = $this->getDoctrine()->getManager();
            $zapytanieX = $em->getRepository('AppBundle:photo')
                ->findAll();
            $ilosc_wierszy = count($zapytanieX);
            $fileName =  $ilosc_wierszy+1 ;
            $fileName2 =  "$fileName.jpg";
            $file->move(
                $this->getParameter('picture_directory2'),
                $fileName2
            );

            $photo->setphoto($fileName2);
            $photo = $form->getData();

            $em->persist($photo);
            $em->flush();

            $this->addFlash('success',
                sprintf('Udało się edytować zdjęcie !')
            );

            return $this->redirectToRoute('gallery-admin');
        }

        return $this->render('admin/gallery-edit.html.twig', [
            'galleryForm' => $form->createView()
        ]);

    return $this->render('admin/gallery-admin.html.twig');
    }

   /**
     * @Route("/admin/gallery-admin/delete/{id}", name="gallery-Cancel")
     */
    public function DeleteGalleryAdmin($id)
    {
          
      $em = $this->getDoctrine()->getManager();

        $photo= $em->getRepository('AppBundle:photo')
            ->findOneBy([
                'id' => $id
            ]);

        $this->addFlash('success',
            sprintf('Udało się usunąć Galerie !')
        );

        $new=$photo->getname();          
        
        $route = __DIR__.'\AdminController.php'; 
        // chdir('%kernel.root_dir%/../galeria/uploads/photos/'.$new); // Comment this out if you are on the same folder
        // chmod('%kernel.root_dir%/../galeria/uploads/photos/'.$new.'/zdjecia',0777);
        chown('%kernel.root_dir%/../galeria/uploads/photos/'.$new, "Rafał");
        chown($route,"Rafał");
        $stat = stat('%kernel.root_dir%/../galeria/uploads/photos/'.$new);
    
        chmod('%kernel.root_dir%/../galeria/uploads/photos/'.$new,0777);
        chmod($route, 0777);
        //  rmdir('%kernel.root_dir%/../galeria/uploads/photos/'.$new);
        $dir = '%kernel.root_dir%/../galeria/uploads/photos/'.$new.'/zdjecia';

        $files1 = scandir($dir);
        unset($files1[0]);
        unset($files1[1]);
        sort($files1);
        $length=count($files1);
        if($length!=0)
        {
        for($i=0;$i<$length;$i++)
        {
        unlink('%kernel.root_dir%/../galeria/uploads/photos/'.$new.'/zdjecia/'.$files1[$i]);
        } 
        }
            rmdir('%kernel.root_dir%/../galeria/uploads/photos/'.$new.'/zdjecia');
            rmdir('%kernel.root_dir%/../galeria/uploads/photos/'.$new);
       

        $em->remove($photo);
        $em->flush();

        return $this->redirectToRoute('gallery-admin');

     return $this->render('admin/gallery-admin.html.twig');
    }



   /**
     * @Route("/admin/g/photos/{name}", name="update-photos")
     */
    public function schowek($name,Request $request)
    {

      $fs = new Filesystem();
   
      $form = $this->createForm(photosForm::class);
      $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
      
      $file=$form->get('photos')->getData();
      $exfile=$file->getClientOriginalName();
     
      $zip = new ZipArchive;
// Jesli pojawia sie bład ze stringiem !! ze empty czy jaki chuj to tak na prawde ten plik wazy za duzo.....
// $ file->getClientOriginalName()
      $x = $zip->open($file);  // open the zip file to extract
      if ($x === true)
     {
     
      $zip->extractTo('%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia'); // place in the directory with same name  
      $zip->close();
     }
      $obrazek = explode('.', $exfile);
       
      $dir = '%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia/'.$obrazek[0];

      $files1 = scandir($dir);
      unset($files1[0]);
      unset($files1[1]);
      sort($files1);
       
      $length=count($files1);
      if($length!=0)
      {
      for($i=0;$i<$length;$i++)
      {
      rename('%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia/'.$obrazek[0].'/'.$files1[$i], '%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia/'.$files1[$i]);
      //   $fs->remove('%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia/', $files1[$i]);
      } 
      }
      rmdir('%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia/'.$obrazek[0]);
      //  rename('%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/'.$obrazek[0], '%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia');
      $this->addFlash('success',
            sprintf('Udało się dodać zdjęcia!')
        );
        return $this->redirectToRoute('gallery-admin');
       }


        $dir = '%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia';

        $photos = scandir($dir);
        unset($photos[0]);
        unset($photos[1]);
        sort($photos); 
    
        $length= count($photos)-1;

    return $this->render('admin/photo-updates.html.twig', [
             'photosForm' => $form->createView(),
             'photos' => $photos,
             'length' => $length,
             'name' => $name
      ]);
     }

  /**
    * @Route("/admin/g/photos/{name}/delete/{name2}", name="photo-Cancel")
    */
   public function singlegalleryDelete($name, $name2)
   {
   
    $this->addFlash('success',
                sprintf('Udało się usunąć zdjęcie !')
            );

   unlink('%kernel.root_dir%/../galeria/uploads/photos/'.$name.'/zdjecia/'.$name2);

   return $this->redirectToRoute('gallery-admin');
   }


  /**
     * @Route("/admin/user", name="users")
     */
    public function users()
    {
        $em = $this->getDoctrine()->getManager();

        $users=$em->getRepository('AppBundle:user')
            ->findAll();

       return $this->render('admin/users.html.twig', [
          'users' => $users
        ]);
    }



   /**
     * @Route("/admin/user/creat", name="users-creat")
     */
    public function usersCreat(Request $request)
    {
       
        $user = new user();

        $form = $this->createForm(UserForm::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

         $em = $this->getDoctrine()->getManager();
         $user = $form->getData();

         
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($user->getpass(), $user->getSalt());
        $user->setpass($password);
        $em->persist($user);
        $em->flush($user);

       $this->addFlash('success',
                sprintf('Udało się stowrzyć artykuł !')
            );

       return $this->redirectToRoute('users');
        }


       return $this->render('admin/users-creat.html.twig', [
         'UserForm' => $form->createView(),
        ]);
    }

     /**
     * @Route("/admin/user/edit/{id}", name="users-edit")
     */
    public function usersEdit(Request $request, user $user)
    {
       
        $form = $this->createForm(UserForm::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

         $em = $this->getDoctrine()->getManager();
         
    //    $user =$em->getRepository('AppBundle:user')
    //        ->findOneBy([
    //            'id' => $id
    //        ]);

         $user = $form->getData();

         $factory = $this->get('security.encoder_factory');
         $encoder = $factory->getEncoder($user);
         $password = $encoder->encodePassword($user->getpass(), $user->getSalt());
         $user->setpass($password);

         $em->persist($user);
         $em->flush();

       $this->addFlash('success',
                sprintf('Udało się Edytować Usera !')
            );

       return $this->redirectToRoute('users');
        }
       return $this->render('admin/users-edit.html.twig', [
         'UserForm' => $form->createView(),
        ]);
    }

 /**
     * @Route("/admin/user/delete/{id}", name="users-delete")
     */
    public function usersDelete($id)
    {

      $em = $this->getDoctrine()->getManager();
       
       $user =$em->getRepository('AppBundle:user')
            ->findOneBy([
                'id' => $id
            ]);

        $em->remove($user);
        $em->flush();
     
         $this->addFlash('success',
                sprintf('Udało się usunąć Usera !')
            );

       return $this->redirectToRoute('users');
    }

}

