<?php

/*

 Xmind project (module DOM)
 Auteur : Thomas Favennec
 version  0.1.2 beta
 support www.redsofa.net

 This file is part of Xmind project.

 Xmind project is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Xmind project distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Xmind project; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA



 ** Xmind DOM functions **

 array XmindGetAttribut(string $Xstring, string $name, string $attribut)
 string XmindSetAttribut(string $Xstring, string $name, string $attribut, string $value)
 array XmindGetHandler(string $Xstring, string $name)
 string XmindSetHandler(string $Xstring, string $name, string $handler)


 */





 // Donne la valeur de l'attribut des balises de nom name="$nom" dans une chaine au format Xmind
// retoune la valeur de l'attribut
function XmindGetAttribute($Xstring, $name, $attribut)
{
 global $Xattribut, $Xname, $Xresult;

 $Xresult="";
 $Xname=$name;
 $Xattribut=strtoupper($attribut);

 $xml_parser = xml_parser_create();
 xml_set_element_handler($xml_parser, 'XMLgetAttribut', 'XMLnull');
 if (!xml_parse($xml_parser, $Xstring)) die(sprintf("Xmind XML error : %s à la ligne %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser) )) ;
 xml_parser_free($xml_parser);

 return($Xresult);
}
// utilisé par XmindGetAttribut
function XMLgetAttribut($parser, $name, $attrs)
{
 global $Xattribut, $Xname, $Xresult;

 $Xoptions=array();
 $attrs2=$attrs;
 if(sizeof($attrs)) while (list($k, $v) = each($attrs)) if($k=='NAME'&&$v==$Xname)
 {
  while (list($k, $v) = each($attrs2)) if($k==$Xattribut) $Xresult[]=$v;
 }

}
function XMLnull($parser, $name)
{ // rien
}








// change l'attribut de la balise de nom name="$name" dans une chaine au format Xmind
// retourne la resource Xmind modifiée
function XmindSetAttribute($Xstring, $name, $attribut, $value)
{
  global $Xstring2, $Xname, $Xvalue, $Xattribut;
  $Xstring2="";
  $Xname=$name;
  $Xattribut=strtoupper($attribut);
  $Xvalue=$value;

  $xml_parser = xml_parser_create();
  xml_set_character_data_handler ( $xml_parser, "XMLchangeHandler");
  xml_set_element_handler($xml_parser, "XMLchangeDebutElement", "XMLchangeFinElement");
  if (!xml_parse($xml_parser, $Xstring)) die(sprintf("Xmind XML error : %s à la ligne %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser) )) ;
  xml_parser_free($xml_parser);

  return($Xstring2);
}
// utilisé par XmindSetAttribut
function XMLchangeDebutElement($parser, $name, $attrs)
{
 global $Xstring2, $Xvalue, $Xattribut, $Xname;
 $Xstring2.='<'.$name;

 $change=0;
 $attrs2=$attrs;
 if(sizeof($attrs))
 {
   while (list($k, $v) = each($attrs)) if($k=='NAME'&&$v==$Xname) $change=1;
   if($change)
   {
     while (list($k, $v) = each($attrs2))
     {
       if($k==$Xattribut);
       else $Xstring2.=' '.$k.'="'.$v.'"';
     }
     $Xstring2.=' '.$Xattribut.'="'.$Xvalue.'"';
   }
   else while (list($k, $v) = each($attrs2)) $Xstring2.=' '.$k.'="'.$v.'"';
 }

 $Xstring2.='>';

}
// utilisé par XmindSetAttribut
function XMLchangeHandler($parser, $data)
{
 global $Xstring2;
 $Xstring2.=$data;
}
// utilisé par XmindSetAttribut
function XMLchangeFinElement($parser, $name)
{
 global $Xstring2;
 $Xstring2.='</'.$name.'>';
}










// Retourne la valeur du handler des balises de nom name='$name' dans un chaine au format Xmind
function XmindGetHandler($Xstring, $name)
{
  global $Xname, $Xvalue;
  $Xvalue='';
  $Xname=$name;

  $xml_parser = xml_parser_create();
  xml_set_character_data_handler ( $xml_parser, 'XMLgetHHandler');
  xml_set_element_handler($xml_parser, 'XMLgetHDebutElement', 'XMLnull');
  if (!xml_parse($xml_parser, $Xstring)) die(sprintf("Xmind XML error : %s à la ligne %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser) )) ;
  xml_parser_free($xml_parser);

  return($Xvalue);
}
// utilisé par XmindGetHandler
function XMLgetHDebutElement($parser, $name, $attrs)
{
 global $Xname, $Xchange;

 $Xchange=0;
 if(sizeof($attrs)) while (list($k, $v) = each($attrs)) if($k=='NAME'&&$v==$Xname) $Xchange=1;
}
// utilisé par XmindGetHandler
function XMLgetHHandler($parser, $data)
{
 global $Xvalue, $Xchange;
 if($Xchange) { $Xvalue[]=$data; $Xchange=0;}
}







// change le texte entre 2 balises nom name="$name" dans un chaine au format Xmind
// retourne la resource Xmind modifiée
function XmindSetHandler($Xstring, $name, $handler)
{
  global $Xstring2, $Xname, $Xhandler;
  $Xstring2='';
  $Xname=$name;
  $Xhandler=$handler;

  $xml_parser = xml_parser_create();
  xml_set_character_data_handler ( $xml_parser, 'XMLchangeHHandler');
  xml_set_element_handler($xml_parser, 'XMLchangeHDebutElement', 'XMLchangeHFinElement');
  if (!xml_parse($xml_parser, $Xstring)) die(sprintf("Xmind XML error : %s à la ligne %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser) )) ;
  xml_parser_free($xml_parser);

  return($Xstring2);
}
// utilisé par XmindSetHandler
function XMLchangeHDebutElement($parser, $name, $attrs)
{
 global $Xstring2, $Xhandler, $Xname, $Xchange;
 $Xstring2.='<'.$name;

 $Xchange=0;
 if(sizeof($attrs)) while (list($k, $v) = each($attrs))
 {
  if($k=='NAME'&&$v==$Xname) $Xchange=1;
  $Xstring2.=' '.$k.'="'.$v.'"';
 }

 $Xstring2.='>';
 if($Xchange) $Xstring2.=$Xhandler;

}
// utilisé par XmindSetHandler
function XMLchangeHHandler($parser, $data)
{
 global $Xstring2, $Xchange;
 if($Xchange) $Xchange=0;
 else $Xstring2.=$data;
}

// utilisé par XmindSetHandler
function XMLchangeHFinElement($parser, $name)
{
 global $Xstring2;
 $Xstring2.='</'.$name.'>';
}










?>
