<?php
/*
 * Classe para agilizar a criação dos formulários
 */

class Form
{
   /*
   static function open($action = '', $method = 'get', $name = 'form1')
   {
      return "<form action='$action' method='$method' name='$name'>\n";
   }

   static function close()
   {
      return "</form>\n";
   }
   */

   static function text($nome, $label, $value = '', $prefixo = '', $tamanho = 255, $maxlength = 255)
   {
      if(empty($prefixo))
      {
         return <<<EOT
<div class="form-group">
   <label for="$nome">$label</label>  
   <input id="$nome" name="$nome" type="text" placeholder="$label" class="form-control input-md" value="$value" />
</div>
EOT;
      }
      else
      {
         return <<<EOT
<div class="form-group">
   <label for="$nome">$label</label>  
   <div class="input-group">
      <span class="input-group-addon">$prefixo</span>
      <input id="$nome" name="$nome" type="text" placeholder="$label" class="form-control input-md" value="$value" />
   </div>
</div>
EOT;
      }
   }

   static function slug($nome, $label, $value = '', $prefixo = '', $tamanho = 255, $maxlength = 255)
   {
      if(empty($prefixo))
      {
         return <<<EOT
<div class="form-group">
   <label for="$nome">$label (<a href='#' id='sugerir-slug'>clique aqui para sugerir</a>)</label>  
   <input id="$nome" name="$nome" type="text" placeholder="$label" class="form-control input-md" value="$value" />
</div>
EOT;
      }
      else
      {
         return <<<EOT
<div class="form-group">
   <label for="$nome">$label (<a href='#' id='sugerir-slug'>clique aqui para sugerir</a>)</label>  
   <div class="input-group">
      <span class="input-group-addon">$prefixo</span>
      <input id="$nome" name="$nome" type="text" placeholder="$label" class="form-control input-md" value="$value" />
   </div>
</div>
EOT;
      }
   }

   static function password($nome = 'senha', $label = 'Senha:', $value = '', $tamanho = 35, $maxlenght = 35)
   {
      return <<<EOT
<div class="form-group">
   <label for="$nome">$label</label>  
   <input id="$nome" name="$nome" type="password" placeholder="$label" class="form-control input-md" value="$value" />
</div>
EOT;
   }

   static function textarea($nome = 'texto', $label = 'Texto:', $value = '', $classe = 'editor')
   {
      return <<<EOT
<div class="form-group">
   <label for="$nome">$label</label>
   <textarea class="form-control $classe" id="$nome" name="$nome">$value</textarea>
</div>
EOT;
   }
   
   static function hidden($nome = 'campo', $value = "valor")
   {
      return "<input type='hidden' value='$value' name='$nome' id='$nome' />";
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
    
   

   */

   static function checkbox($name = 'selecione', $label = "Selecione:", $value = 'selecionado', $checked = FALSE)
   {
      $checked = $checked ? "checked='checked' " : "";
      return <<<EOT
<div class="form-group">
   <label><input $checked type='checkbox' name='$name' value='$value'> $label </label><br />
</div>
EOT;
   }

   static function checkboxgroup($name = 'selecione', $label = "Selecione:", $opcoes = array(), $checked = array())
   {
      $retorno = "
      <div class='form-group'>
         <label class='control-label' for='$name'>$label</label><br>";

      foreach($opcoes as $chave => $opcao)
      {
         $checkedStr = in_array($chave, $checked) ? "checked='checked' " : '';
         $retorno .= "<label style='font-weight: normal;'><input {$checkedStr}type='checkbox' name='{$name}[]' value='$chave'> $opcao </label><br />";
      }

      $retorno .= "</div>";

      return $retorno;
   }

   static function select($nome = 'opcao', $label = 'Opção:', $opcoes = array(), $selected = '')
   {
      $retorno = "
      <div class='form-group'>
         <label class='control-label' for='$nome'>$label</label>
         <select name='$nome' id='$nome' class='form-control'>";

      foreach($opcoes as $chave => $opcao)
      $retorno .= "<option".($selected == $chave ? " selected='selected'" : "")." value='$chave'>$opcao</option>";

      $retorno .=
      "  </select>
      </div>
      ";

      return $retorno;
   }

   static function data_picker($name = 'data', $label = "Data:", $value = '')
   {
      return
      self::text($name, $label, $value).
      "<script type='text/javascript'>
         $('#$name').ready(function(){ $('#$name').datetimepicker({ locale: 'pt-BR', format: 'DD/MM/YYYY HH:mm:ss' }) });
      </script>";
   }

   static function tags($nome = 'data', $label = "Data:", $value = '')
   {
      return <<<EOT
<div class="form-group">
   <label for="$nome">$label</label><br />  
   <input data-role="tagsinput" id="$nome" name="$nome" type="text" placeholder="$label" class="form-control input-md" value="$value" />
</div>
EOT;
   }
    
   static function image_picker($nome, $label, $value = '', $tamanho = 255, $maxlength = 255)
   {
      return <<<EOT
<div class="form-group">
   <label for="$nome">$label</label>
   <div class="row">
      <div class="col-md-10">
         <input id="$nome" name="$nome" type="text" placeholder="$label" class="form-control input-md campo-imagem" value="$value" />
      
         <button class="btn btn-primary btn-procurar-servidor">Procurar no servidor</button>
         <button class="btn btn-danger btn-limpar-imagem">Limpar</button>  
      </div>
      
      <div class="col-md-2">
         <img src="/admin/imgs/no-image.png" class="imagem-listagem preview-form-imagem" />
      </div>
      
   </div>
</div>
EOT;
   }

   static function file_picker($nome, $label, $value = '', $tamanho = 35, $maxlength = 35)
   {
      return <<<EOT
<div class="form-group">
   <label for="$nome">$label</label>
   <div class="row">
      <div class="col-md-12">
         <input id="$nome" name="$nome" type="text" placeholder="$label" class="form-control input-md campo-imagem" value="$value" />
      
         <button class="btn btn-primary btn-procurar-servidor">Procurar no servidor</button>
         <button class="btn btn-danger btn-limpar-imagem">Limpar</button>  
      </div>
      <!--
      <div class="col-md-2">
         <img src="/admin/imgs/no-image.png" class="imagem-listagem preview-form-imagem" />
      </div>
      -->
      
   </div>
</div>
EOT;
   }

   static function cidadeajax($nome = 'opcao', $label = 'Opção:', $id_cidade = false, $nome_cidade = false)
   {
      $html = "
      <div class='form-group'>
         <label for='$nome'>$label</label>
         <select name='$nome' class='select-cidades-ajax form-control'>";

      if($id_cidade and $nome_cidade)
      {
         $html .= "\n<option value='$id_cidade' selected='selected'>$nome_cidade</option>";
      }
      else
      {
         $html .= "\n<option value='0' selected='selected'>Selecione</option>";
      }

      return $html . "\n</select></div>";
   }
   
   /*
   static function image_bulk($nome, $label)
   {
      return "<label>$label</label><textarea cols='90' rows='10' name='$nome' id='$nome' onclick='openKCFinderBulk(this);' style='cursor: pointer;'>Clique...</textarea>";
   }
   */
   
   /*
   static function select_uf($selected = '')
   {
      return self::select('uf', "UF:", Util::get_array_uf(), $selected);
   }
   
   static function select_cidade($uf, $selected = '1')
   {
      return self::select_lazy('cidade', 'Cidade:', Model::factory('Cidade')->listar_lazy($uf), $selected);
   }
   
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
   */
}

?>