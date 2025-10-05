<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index ( Router $router) {

        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros( Router $router) {

         $router->render('paginas/nosotros');
    }
    public static function propiedades( Router $router) {
       
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades   
        ]);
    }
    public static function propiedad( Router $router ) {

         $id = validarORedireccionar('/propiedadades');

         //buscar la propiedad por su id
        $propiedad = Propiedad::find($id);
        
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog( Router $router ) {
        
        $router->render('paginas/blog');
    }    
    public static function entrada( Router $router) {       
        $router->render('paginas/entrada');
    }
    public static function contacto( Router $router ) {

         $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $respuestas = $_POST['contacto'];
                      
            //Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '7013966476d494';
            $mail->Password = 'd704fbf7a2c12f';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Configurar el contenid del Mail
            $mail->setFrom('admin@bienesraices.com');         
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');            
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTML
            $mail->isHTML(true);      
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>'; 
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';             

            // Enviar de forma condicional algunos campos de email y telefono   
            if($respuestas['contacto'] === 'telefono') {
                 $contenido .= '<p>Eligió ser contactado por Télefono:<p>';
                 $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . ' </p>'; 
                 $contenido .= '<p>Fecha de contacto: ' . $respuestas['fecha'] . ' </p>'; 
                 $contenido .= '<p>Hora de contacto: ' . $respuestas['hora'] . ' </p>'; 
                 
            }else {
                //Es email, entonces agregamos el campo de Email
                $contenido .= '<p>Eligió ser contactado por email:<p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>'; 
            }
           
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>'; 
            $contenido .= '<p>Compra o Vende: ' . $respuestas['tipo'] . ' </p>'; 
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>'; 
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio'] . ' </p>'; 
            $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . ' </p>'; 
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es un texto alternativo';
            
            //Enviar el Email
            if($mail->send()) {
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar...";
            }     
        }
        
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    } 
}