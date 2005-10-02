<?php

 /*

 Xmind project (GTK parse core)
 Auteur : Thomas Favennec
 version  0.1.0 alpha
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



 ** Xmind parse functions **

 string XmindOpenFile(file $file)
 string XmindParseFile(file $file)
 string XmindParse(string $string)


 */


 dl('php_gtk.'.(strstr(PHP_OS,'WIN')?'dll':'so'))||die("GTK Xmind error : Iimpossibe de charger PHPGTK !\n");


 // situe l'emlacement du répertoire Xmind
 function XmindSetPath($path)
 {
  global $Xpath;
  if(!file_exists($path.'/Xmind/Xmind.php'))  die("GTK Xmind error : Impossible de situer le répertoire Xmind sur $path .");
  if($path{strlen($path)-1}!='/') $path.='/';
  $Xpath=$path;
 }


 // retourne le contenu d'un fichier
 function XmindOpenFile($file)
 {
   if (!($fp = fopen($file, "r"))) die("GTK Xmind error : Impossible d'ouvrir le fichier $file");
   return(fread($fp, filesize($file)));
 }


 // interprète un fichier au format Xmind
 function XmindParseFile($file)
 {
   if (!($fp = fopen($file, "r"))) die("GTK Xmind error : Impossible d'ouvrir le fichier $file");
   return(XmindParse(fread($fp, filesize($file))));
 }



 // interprète une chaine format Xmind
 function XmindParse($string)
 {
  global $Xn;

  $string=str_replace("\r", '', $string);
  $string=str_replace("\n", '', $string);

  $xml_parser=xml_parser_create();
  xml_set_character_data_handler($xml_parser,'XMLparseHandler');
  xml_set_element_handler($xml_parser,'XMLparseDebutElement','XMLparseFinElement');
  if (!xml_parse($xml_parser, $string)) die('Xmind error : Des erreurs XML sont signalée par le parser !') ;
  xml_parser_free($xml_parser);

  return('');
 }




// utilisé par Xmindparse
function XMLParseDebutElement($parser, $name, $attrs)
{
 global $Xlasthandler,$Xw,$Xpath,$Xoptions,$Xn,$Yn,$Xparent,$Xcontainer,$Yc;

 $Yn++;
 
 $Xoptions=array();
 if(sizeof($attrs)) while (list($k, $v) = each($attrs)) $Xoptions[$k]=$v;
 $Xlasttag=$name;

 if($name=='XMIND')
 {
  $Xn[XMIND]++;
  $Yn=0;
  $Yc=0;
  if(!$Xoptions[NAME]) $Xoptions[NAME]='xmind';
  $Xparent[$Yn]=&new GtkWindow();
  $Yw[$Xoptions[NAME]]=$Yn;
  $Xparent[$Yn]->set_title($Xoptions[TITLE]);
  $Xparent[$Yn]->show();
  $Xparent[$Yn]->connect_object('destroy', array('gtk', 'main_quit'));

  $vbox=&new GtkVBox();
  if(!$Xoptions[MARGE]) $Xoptions[MARGE]=10;
  $vbox->set_border_width($Xoptions[MARGE]);
  $Xparent[$Yn]->add($vbox);

  $Xcontainer[0]=$vbox;
 }
 if($name=='CODE') $Xtemp[CODE]=$Xoptions[NAME];
 if($name=='HBOX')
 {
  $Xn[HBOX]++;
  $Yc++;
  if(!$Xoptions[NAME]) $Xoptions[NAME]='hbox'.$Xn[VBOX];
  $Xparent[$Yn]=&new GtkHBox();
  $Yw[$Xoptions[NAME]]=$Yn;
  if(!$Xoptions[SPAN]) $Xoptions[SPAN]=1;
  $Xparent[$Yn]->set_spacing($Xoptions[SPAN]);
  $Xparent[$Yn]->set_border_width($Xoptions[SPAN]);
  $Xcontainer[$Yc-1]->pack_start($Xparent[$Yn],0,0);
  $Xcontainer[$Yc]=$Xparent[$Yn];
 }
 if($name=='VBOX')
 {
  $Xn[VBOX]++;
  $Yc++;
  if(!$Xoptions[NAME]) $Xoptions[NAME]='vbox'.$Xn[VBOX];
  $Xparent[$Yn]=&new GtkVBox();
  $Yw[$Xoptions[NAME]]=$Yn;
  if(!$Xoptions[SPAN]) $Xoptions[SPAN]=1;
  $Xparent[$Yn]->set_spacing($Xoptions[SPAN]);
  $Xparent[$Yn]->set_border_width($Xoptions[SPAN]);
  $Xcontainer[$Yc-1]->pack_start($Xparent[$Yn],0,0);
  $Xcontainer[$Yc]=$Xparent[$Yn];
 }
 if($name=='TBOX')
 {
 }
 if($name=='TR')
 {
 }
 if($name=='TD')
 {
 }
 if($name=='LAYER')
 {
 }
 if($name=='FRAME')
 {
  $Xn[FRAME]++;
  $Yc++;
  if(!$Xoptions[NAME]) $Xoptions[NAME]='frame'.$Xn[FRAME];
  $Xparent[$Yn]=&new GtkFrame($Xoptions[TITLE]);
  $Yw[$Xoptions[NAME]]=$Yn;

  $vbox=&new GtkVBox();
  $Xoptions[MARGE]+=4;
  $vbox->set_border_width($Xoptions[MARGE]);
  $Xparent[$Yn]->add($vbox);
  $Xcontainer[$Yc-1]->pack_start($Xparent[$Yn],0,0);
  $Xcontainer[$Yc]=$vbox;
 }
 if($name=='NOTEBOOK')
 {
 }
 if($name=='PAGE')
 {
 }
 if($name=='CLIST')
 {
 }


}



// utilisé par Xmindparse
function XMLparseHandler($parser, $data)
{
 global $Xlasthandler,$Xlasttag;
 if($Xlasttag=='CODE'||$Xlasttag=='SCRIPT') $Xlasthandler.=$data;
 else $Xlasthandler=trim($data);
}



// utilisé par Xmindparse
function XMLparseFinElement($parser, $name)
{
 global $Xlasthandler,$Xw,$Xpath,$Xoptions,$Xn,$Yn,$Xparent,$Xcontainer,$Yc;

 if($name=='SCRIPT') $Xstring.=$Xlasthandler.'</script>';
 if($name=='CODE') if ($Xtemp[CODE])
 {
 }
 if($name=='HBOX') $Yc--;
 if($name=='VBOX') $Yc--;
 if($name=='FRAME') $Yc--;
 if($name=='TBOX')
 {
 }
 if($name=='TR')
 {
 }
 if($name=='TD')
 {
 }
 if($name=='LAYER')
 {
 }
 if($name=='NOTEBOOK')
 {
 }
 if($name=='PAGE')
 {
 }
 if($name=='LABEL')
 {
 }
 if($name=='ENTRY')
 {
 }
 if($name=='TEXT')
 {
 }
 if($name=='HIDDEN')
 {
 }
 if($name=='SPIN')
 {
 }
 if($name=='BUTTON')
 {
  $Xn[BUTTON]++;
  if(!$Xoptions[NAME]) $Xoptions[NAME]='button'.$Xn[BUTTON];
  $Xparent[$Yn]=&new GtkButton($Xlasthandler);
  $Yw[$Xoptions[NAME]]=$Yn;

  $Xoptions[ONCLICK]=str_replace("'", "\\'", $Xoptions[ONCLICK]);

  if($Xoptions[ACTIVE]=='0') $Xparent[$Yn]->set_sensitive(0);
  $Xcontainer[$Yc]->pack_start($Xparent[$Yn],0,0);

  //$Xoptions[NAME],$Xlasthandler,$Xoptions[IMAGE],$Xoptions[ONCLICK],$Xoptions[VALUE],$Xoptions[ACTIVE], $Xoptions[WIDTH]).XmindBetweenBox($Xtemp,$Xbox);
 }
 if($name=='TOGGLE')
 {
 }
 if($name=='CHECKBOX')
 {
 }
 if($name=='RADIO')
 {
 }
 if($name=='PROGRESSBAR')
 {
 }
 if($name=='IMAGE')
 {
 }
 if($name=='DRAWINGAREA')
 {
 }
 if($name=='CLIST')
 {
 }
 if($name=='OPTION')
 {
 }

 if($name=='XMIND')
 {
  $Xparent[0]->show_all();
  gtk::main();
 }


}








// trace une feuille de style CSS du thème $Xtheme dans la page
function XmindStyle($Xpath,$Xtheme)
{
 $a=$Xpath.'Xmind/themes/'.$Xtheme.'/style.css';
 $fp=fopen($a, 'r');
 $s=fread($fp, filesize($a));
 fclose($fp);
 $s=str_replace('url(\'', 'url(\''.$Xpath.'Xmind/themes/'.$Xtheme.'/', $s);
 return($s);
}









?>
