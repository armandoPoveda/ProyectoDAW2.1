<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class mainController extends AbstractController
{
    /** 
     *@Route("/", name="index")
     */
    public function index()
    {
        $title = 'HOME';
        return $this->render('index.html.twig', ['title' => $title]);
    }

    /** 
     *@Route("/servicios", name="servicios")
     */
    public function servicios()
    {
        $title = 'SERVICIOS';
        return $this->render('servicios.html.twig', ['title' => $title]);
    }

    /** 
     *@Route("/nosotros", name="nosotros")
     */
    public function nosotros()
    {
        $title = 'NOSOTROS';
        return $this->render('nosotros.html.twig', ['title' => $title]);
    }

    /** 
     *@Route("/contacto", name="contacto")
     */
    public function contacto()
    {
        $title = 'CONTACTO';

        return $this->render('contacto.html.twig', ['title' => $title]);
    }

    /** 
     *@Route("/login", name="login")
     */
    public function login()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find(1);
        $name = $user->getName();
        $password = '1234';
        $title = 'LOGIN';
        if ($name != null) {
            $name = $user;
        } else {
            $name = 'Introduce tus datos de usuario para iniciar la sesión.';
        }
        return $this->render('login.html.twig', ['user' => $name, 'password' => $password, 'title' => $title]);
    }

    /** 
     *@Route("/proyectos/{pagina}", name="proyectos")
     */
    public function proyectos($pagina)
    {
        $title = 'PROYECTOS';
        if (is_numeric($pagina)) {
            switch ($pagina) {
                case 1:
                    return $this->render('proyectos.html.twig', ['title' => $title]);
                    break;
                case 2:
                    return $this->render('proyectos_page2.html.twig', ['title' => $title]);
                    break;
                default:
                    return $this->render('proyectos.html.twig', ['title' => $title]);
                    break;
            }
        } else {
            return $this->render('proyectos.html.twig', ['title' => $title]);
        }
    }

    /**
     *@Route("/PersistirDatos", name="PersitirDatos") 
     */

    public function PersistirDatos()
    {
        $title = 'DATOS CONTACTO';
        $nombre = $_POST['name'];
        $email = $_POST['email'];
        $mensaje = $_POST['message'];
        if ($nombre != '' && $email != '' && $mensaje != '') {
            $entityManager = $this->getDoctrine()->getManager();

            $user = new User($nombre, $email, $mensaje);
            $entityManager->persist($user);

            $entityManager->flush();
            
            return $this->render('resultContacto.html.twig', ['nombre' => $nombre, 'email' => $email, 'mensaje' => $mensaje, 'title' => $title]);;
        } else {
            dump('Faltan datos obligatorios');
            return $this->render('<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <img src="..." class="rounded mr-2" alt="...">
              <strong class="mr-auto">Bootstrap</strong>
              <small>11 mins ago</small>
              <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body">
              Hello, world! This is a toast message.
            </div>
          </div>');
        }
        return $this->render('contacto.html.twig', ['title' => $title]);
    }
}
