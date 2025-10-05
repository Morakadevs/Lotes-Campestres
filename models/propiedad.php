<?php

namespace Model;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc',
    'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc; 
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

       public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar(){

         if(!$this->titulo){
            self::$errores[] = "Debes añadir un titulo";
    }
    
       if(!$this->precio){
        self::$errores[] = "El Precio es Obligatorio";
    }

       if( strlen($this->descripcion) < 50 ) {
        self::$errores[] = "La Descripción es Obligatoria y debe tener al menos 50 caracteres";
    }

       if(!$this->habitaciones){
        self::$errores[] = "EL numero de las Habitaciones son Obligatorias";
    }

        if(!$this->wc){
        self::$errores[] = "EL numero de las Baños son Obligatorias";
    }

        if(!$this->estacionamiento){
        self::$errores[] = "EL numero de las Estacionamiento son Obligatorias";
    }

        if(!$this->vendedores_id){
        self::$errores[] = "Elige un Vendedor";
    }

    if(!$this->imagen) {
        self::$errores[] = 'La Imagen de la propiedad es Obilgatoria';
    }
 
        return self::$errores;
    }
} 