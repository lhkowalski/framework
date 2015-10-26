<?php



class Template

{

   protected $vars;

   protected $filename;



   public function  __construct($file) {

      $this->filename = $file;

      $this->vars = array();

   }



   public function  __set($name, $value) {

      $this->vars[$name] = $value;

   }



   public function  __get($name) {

      return $this->vars[$name];

   }



   public function render()

   {

      $arquivo = APPS_DIR.'/'.$this->filename;

      if(file_exists($arquivo))

      {

         $content = "";

         extract($this->vars);



         ob_start();

         require($arquivo);

         $content = ob_get_contents();

         ob_end_clean();



         return $content;

      }

      else

      {

         throw new Exception("Template ".$this->filename." not found.");

      }

   }



   public function  __toString() {

      try

      {

         return $this->render();

      }

      catch(Exception $e)

      {
   var_dump($e);
         die("Template not found!");

      }

   }

}