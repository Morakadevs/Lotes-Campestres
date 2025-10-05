<?php

 namespace Controllers;
 use MVC\Router;
 use Model\Propiedad;
 use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

  
 class PropiedadController {
    public static function index (Router $router) {
        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all(); 

        // Muestra mensaje condicional 
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
      ]); 
      
    }
  
    public static function crear (Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
    //Arreglo con mensajes de errores
      $errores = Propiedad::getErrores(); 

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Crea una nueva instancia
            $propiedad = new Propiedad($_POST['propiedad']);

           
            //Generar un mombre unico
            $nombreImagen = md5( uniqid(rand(), true ) ) . ".jpg";

            //Setear la imagen
            //Realiza un resize a la imagen con intervention
          if($_FILES['propiedad']['tmp_name']['imagen']) {
          $manager = new Image(Driver::class);
          $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
          $propiedad->setImagen($nombreImagen);
      }

            //Validar
            $errores = $propiedad->validar();   
                            
            if(empty($errores)) {        
    
            // Crear la carpeta para subir imagenes   
            if(!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }           
            
            //Guardar imagen si existe           
            $image->save(CARPETA_IMAGENES . $nombreImagen);                                                                                                                                                                                                                                                                                                            

           // Guardar en la base de datos
            $propiedad->guardar();            
        }
    }

        $router->render('propiedades/crear', [
          'propiedad' => $propiedad,
          'vendedores' => $vendedores,
          'errores' => $errores
        ]);         
    }
    
     public static function actualizar (Router $router) {
         
      $id = validarORedireccionar('/admin');
      $propiedad = Propiedad::find($id);

      $vendedores = Vendedor::all();

      $errores = Propiedad::getErrores();

         //Ejecutar el codigo después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {           
    //Asignar los atributos
        $args = $_POST['propiedad']; 
        
    //Sincronizar los cambios                                        
       $propiedad->sincronizar($args);
        //Validacion        
       $errores = $propiedad->validar();     
                  
        //Generar un mombre unico  
            $nombreImagen = md5( uniqid(rand(), true ) ) . ".jpg"; 
                
            //Subida de archivos
        if($_FILES['propiedad']['tmp_name']['imagen']) {
             $manager = new Image(Driver::class);
             $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        if(empty($errores)) { 
             if($_FILES['propiedad']['tmp_name']['imagen']) {        
         //Almacener la imagen
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            }                    
         $propiedad->guardar();        
    }   
 }
      $router->render('/propiedades/actualizar', [
        'propiedad' => $propiedad,
        'errores' => $errores,
        'vendedores' => $vendedores
      ]);
    }

    public static function eliminar() {
       if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tipo = $_POST['tipo'];                            
            if(validarTipoContenido($tipo)) {
                //Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
              $propiedad = Propiedad::find($id); 
              $propiedad->eliminar();
            } 
                    
        }    
    }
 }