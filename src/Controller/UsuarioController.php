<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Users;
use App\Form\RegisterType;
use App\Form\UpdateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;

class UsuarioController extends AbstractController
{
    
    public function crearUsuario(Request $request,UserPasswordEncoderInterface $encoder)
    {

        $usuario = new Users();
        $form = $this -> createForm(RegisterType::class,$usuario);

        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            
            $usuario->setRole('ROLE_USER');
            $usuario->setFechaalta(new \Datetime('now'));
            $encoded= $encoder -> encodePassword($usuario,$usuario->getPassword());
            $usuario->setPassword($encoded);
            $em= $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

        }

        return $this->render('usuario/crearUsuario.html.twig', [
            'form'=>$form->createView(),
            ]);
    }

    public function login(AuthenticationUtils $autenticationUtils){
        $error= $autenticationUtils->getLastAuthenticationError();    
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('usuario/login.html.twig',array(
            'error'=>$error,
            'last_username'=> $lastUsername
        ));
    }
    public function log(){
        return $this->render('usuario/login.html.twig');
    }
    public function getUsuarios()
    {
        $usuariosRepo=$this->getDoctrine()->getRepository(Users::class);
        $usuarios= $usuariosRepo->findAll();
        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }
    public function tomaid(UserInterface $hola){
        $id=$hola->getId();
        return $id;
    }
    public function delUser(Users $id){
        $em = $this -> getDoctrine() -> getManager();
        $em -> remove($id);
        $em -> flush();  
        return new Response('Registro Borrado');  
    }

    public function upUsuarios(Users $usuario,Request $request,UserPasswordEncoderInterface $encoder)
    {
        $form = $this -> createForm(UpdateType::class,$usuario);

        $form->handleRequest($request);
       

        if($form->isSubmitted()){
          
            
            $usuario->setFechaalta(new \Datetime('now'));
            $encoded= $encoder -> encodePassword($usuario,$usuario->getPassword());
            $usuario->setPassword($encoded);
            $em= $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            return $this->redirectToRoute('getusuarios');
        }

        return $this->render('usuario/actUsr.html.twig', [
            'form'=>$form->createView(),
            'usuarios'=>$usuario
            ]);    }
    
}
