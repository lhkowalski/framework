<?php
/*
 * Classe para agilizar a criação dos formulários
 */

class Form
{
   static function open($action = '', $method = 'get', $name = 'form1')
   {
      return "<form action='$action' method='$method' name='$name'>\n";
   }

   static function close()
   {
      return "</form>\n";
   }
   
   static function textarea_clean($nome = 'texto', $label = "Texto:", $value = "")
   {
      return
         "
         <label for='$nome'>$label</label>
         <textarea name='$nome' id='$nome' cols='40' rows='8'>$value</textarea>
         ";
   }

   static function text($nome, $label, $value = '', $tamanho = 35, $maxlength = 35)
   {
      return
      "<label for='$nome'>$label</label>
      <input type='text' value='$value' name='$nome' id='$nome' size='$tamanho' maxlength='$maxlength' />";
   }

   static function password($nome = 'senha', $label = 'Senha:', $value = '', $tamanho = 35, $maxlenght = 35)
   {
      return
      "<label for='$nome'>$label</label>
      <input type='password' value='$value' name='$nome' id='$nome' size='$tamanho' maxlength='$maxlength' />";
   }

   static function textarea($nome = 'texto', $label = 'Texto:', $value = '')
   {
      return
      "
      <label for='$nome'>$label</label>
      <textarea name='$nome' id='$nome'>$value</textarea>
      <script type='text/javascript'>$('#$nome').ready(function(){ $('#$nome').ckeditor(); })</script>";
   }

   static function submit($value = 'Enviar', $nome = 'enviar')
   {
      return "<input type='submit' value='$value' name='$nome' />";
   }
   
   static function hidden($nome = 'campo', $value = "valor")
   {
      return "<input type='hidden' value='$value' name='$nome' id='$nome' />";
   }

   static function reset($value = 'Limpar', $nome = 'limpar')
   {
      return "<input type='reset' value='$value' name='$nome' />";
   }
   /*
   static function select_lazy($nome = 'opcao', $label = 'Opção:', $objeto = NULL, $selected = '')
   {
      $retorno = "
      <label for='$nome'>$label</label>
      <select name='$nome' id='$nome'>";

      if($objeto)
      {
         while($objeto->next())
         {
            $chave = $objeto->getValue('id');
            $opcao = $objeto->getValue('titulo');
            $retorno .= "<option".($selected == $chave ? " selected='selected'" : "")." value='$chave'>$opcao</option>";
         }
      }
      else
      {
         $retorno .= "<option value='0'>Nenhum</option>";
      }
      $retorno .=
      "</select>
      ";

      return $retorno;
   }
   */
    
   static function select_lazy($nome = 'opcao', $label = 'Opção:', $itens = NULL, $selected = '')
   {
      $retorno = "
      <label for='$nome'>$label</label>
      <select name='$nome' id='$nome'>";

      if(is_array($itens) and count($itens) > 0)
      {
         foreach($itens as $i)
         {
            $chave = $i->id;
            $opcao = $i->nome;
            $retorno .= "<option".($selected == $chave ? " selected='selected'" : "")." value='$chave'>$opcao</option>";
         }
      }
      else
      {
         $retorno .= "<option value='0'>Nenhum</option>";
      }
      $retorno .=
      "</select>
      ";

      return $retorno;
   }
   
   static function select($nome = 'opcao', $label = 'Opção:', $opcoes = array(), $selected = '')
   {
      $retorno = "
      <label for='$nome'>$label</label>
      <select name='$nome' id='$nome'>";

      foreach($opcoes as $chave => $opcao)
      $retorno .= "<option".($selected == $chave ? " selected='selected'" : "")." value='$chave'>$opcao</option>";

      $retorno .=
      "</select>
      ";

      return $retorno;
   }
    
   static function checkbox($name = 'selecione', $label = "Selecione:", $value = 'selecionado', $checked = FALSE)
   {
      return "<input ".($checked ? "checked='checked' " : "")."type='checkbox' name='$name' value='$value'> $label <br />";
   }

   static function data_picker($name = 'data', $label = "Data:", $value = '')
   {
      return
      self::text($name, $label, $value, 10, 10).
            "<script type='text/javascript'>$('#$name').ready(function(){ $('#$name').datepicker(); })</script>";
   }
    
   static function file_picker($nome, $label, $value = '', $tamanho = 100, $maxlength = 35)
   {
      return
         "<label for='$nome'>$label</label>
         <input type='text' value='$value' name='$nome' id='$nome' size='$tamanho' maxlength='$maxlength' onclick='openKCFinder(this);' />
         ";
   }
   
   static function image_picker($nome, $label, $value = '', $tamanho = 35, $maxlength = 35)
   {
      return self::file_picker($nome, $label, $value, $tamanho, $maxlength);
   }
   
   static function image_bulk($nome, $label)
   {
      return "<label>$label</label><textarea cols='90' rows='10' name='$nome' id='$nome' onclick='openKCFinderBulk(this);' style='cursor: pointer;'>Clique...</textarea>";
   }
   
   /*
   static function select_uf($selected = '')
   {
      return self::select('uf', "UF:", Util::get_array_uf(), $selected);
   }
   
   static function select_cidade($uf, $selected = '1')
   {
      return self::select_lazy('cidade', 'Cidade:', Model::factory('Cidade')->listar_lazy($uf), $selected);
   }
   */
   
   static function select_estado($nome = 'opcao', $label = 'Opção:', $itens = NULL, $selected = '')
   {
      return self::select_lazy($nome, $label, $itens, $selected);
   }
   
   static function select_cidade($nome = 'opcao', $label = 'Opção:', $itens = NULL, $selected = '')
   {
      return self::select_lazy($nome, $label, $itens, $selected);
   }
   
   static function js_locais($estado = 'estado', $cidade = 'cidade', $bairro = 'bairro')
   {
      return 
         "
         <script type='text/javascript'>
            $('#$cidade').ready(function(){
               $('#$cidade').change(function(){                   
                  // Mudou a cidade: carregar os bairros
                  var cidade = $(this).attr('value');                  
                  var url = '/admin/index.php?modulo=local&sub_modulo=bairro&acao=carregar_bairros&cidade='+cidade;
                  $('#$bairro').load(url);
               });
            });
            
            $('#$estado').ready(function(){
               $('#$estado').change(function(){
                  // Mudou o estado: carregar as cidades
                  var estado = $(this).attr('value');
                  var url = '/admin/index.php?modulo=local&sub_modulo=cidade&acao=carregar_cidades&estado='+estado;
                  $('#$cidade').load(url, function(){
                     $('#$cidade').change();
                  });
               });
            });            
            
         </script>";
   }
   
   static function radio($name = 'selecione', $label = "Selecione:", $value = "selecionado", $checked = FALSE)
   {
      return "<input ".($checked ? "checked='checked' " : "")."type='radio' name='$name' value='$value'> $label <br />";
   }
   
   static function button($name, $value)
   {
      return "<button id='$name'>$value</button>";
   }
}

?>
