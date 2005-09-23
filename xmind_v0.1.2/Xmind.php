<?php



 /*

 Xmind project (parse core)
 Auteur : Thomas Favennec
 version  0.1.2d alpha
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



 include('Xwidgets.php');


 // variables globales
 $Xpath='';
 
 // **

 // situe l'emlacement du répertoire Xmind
 function XmindSetPath($path)
 {
  global $Xpath;
  if(!file_exists($path.'/Xmind/Xmind.php'))  die("Xmind error : Impossible de situer le répertoire Xmind sur $path .");
  if($path{strlen($path)-1}!='/') $path.='/';
  $Xpath=$path;
 }


 // retourne le contenu d'un fichier
 function XmindOpenFile($file)
 {
   if (!($fp = fopen($file, "r"))) die("Xmind error : Impossible d'ouvrir le fichier $file");
   return(fread($fp, filesize($file)));
 }


 // interprète un fichier au format Xmind
 // retourne l'html à afficher
 function XmindParseFile($file)
 {
   if (!($fp = fopen($file, "r"))) die("Xmind error : Impossible d'ouvrir le fichier $file");
   return(XmindParse(fread($fp, filesize($file))));
 }



 // interprète une chaine format Xmind
 // retourne l'html a afficher
 function XmindParse($string)
 {
   global $Xstring, $Xn;
   $Xstring="";

   $string=str_replace("\r", '', $string);
   $string=str_replace("\n", '', $string);
   
   $xml_parser = xml_parser_create();
   xml_set_character_data_handler($xml_parser, "XMLparseHandler");
   //xml_set_processing_instruction_handler($xml_parser, "XMLparseNdata");
   xml_set_element_handler($xml_parser, "XMLparseDebutElement", "XMLparseFinElement");
   if (!xml_parse($xml_parser, $string)) die(sprintf("Xmind XML error : %s à la ligne %d", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser) )) ;
   xml_parser_free($xml_parser);


   return($Xstring);
 }


// utilisé par Xmindparse
function XMLParseDebutElement($parser, $name, $attrs)
{
 global $Xstring, $Xpath, $Xoptions, $Xtheme, $Xlasttag, $XlastName, $Xn,
 $Xtemp, $lastNB, $Xintegration, $Yb;

 $Xoptions=array();
 if(sizeof($attrs)) while (list($k, $v) = each($attrs)) $Xoptions[$k]=$v;
 $Xlasttag=$name;

 if($name=='XMIND')
 {
  $Xn[XMIND]++;
  if($Xoptions[THEME]) $Xtheme=$Xoptions[THEME]; else $Xtheme='default'; // theme par default
  $Xintegration=$Xoptions[INTEGRATIONTYPE];
  if($Xoptions[ONLOAD]) $Xoption[ONLOAD]='defaultonload="'.str_replace("'", "\\'", $Xoptions[ONLOAD]).'";';
  if(!file_exists($Xpath.'Xmind/themes/'.$Xtheme)) die('Xmind error : le theme spécifié est introuvale !');
  if($Xintegration!='plain') $Xstring.='<html><head><title>'.$Xoptions[TITLE].'</title></head><body leftmargin="'.$Xoptions[MARGE].'" topmargin="'.$Xoptions[MARGE].'" class="frame">';
  if($Xn[XMIND]==1) $Xstring.='<script language="Javascript">var path="'.$Xpath.'"; var theme="'.$Xtheme.'"; '.$Xoption[ONLOAD].'</script> <script language="Javascript" src="'.$Xpath.'Xmind/Xmind.js"></script><style type="text/css">'.XmindStyle($Xpath,$Xtheme).'</style>
  <div style="z-index: 0; position: absolute; visibility: hidden; left: 500px"><iframe name="Xaction" id="Xaction" height="100" width="100" style="display:none;"></iframe></div>
  <form method="POST" TARGET=""><input type="hidden" name="Xtheme" value="'.$Xtheme.'"><input type="hidden" name="Xpath" value="'.$Xpath.'">';
 }
 if($name=='SCRIPT') $Xstring.='<script language="javascript">';
 if($name=='CODE') $Xtemp[CODE]=$Xoptions[NAME];
 if($name=='TBOX')
 {
   if(!$Xoptions[SPAN]) $Xoptions[SPAN]=1;
   $Xstring.='<table cellpadding="'.$Xoptions[SPAN].'" cellspacing="'.$Xoptions[SPAN].'" height="'.$Xoptions[HEIGHT].'" width="'.$Xoptions[WIDTH].'" align="'.$Xoptions[ALIGN].'" valign="'.$Xoptions[VALIGN].'">';
 }
 if($name=='TR')$Xstring.='<tr>';
 if($name=='TD')
 {
  if(!$Xoptions[VALIGN]) $Xoptions[VALIGN]='middle';
  $Xstring.='<td height="'.$Xoptions[HEIGHT].'" width="'.$Xoptions[WIDTH].'" colspan="'.$Xoptions[COLSPAN].'" rowspan="'.$Xoptions[ROWSPAN].'" align="'.$Xoptions[ALIGN].'" valign="'.$Xoptions[VALIGN].'">';
 }
 if($name=='LAYER') $Xstring.='<div name="'.$Xoptions[NAME].'" style="z-index: '.$Xoptions[Z].'; position: absolute; left:'.$Xoptions[X].'px; top:'.$Xoptions[Y].'px; width:'.$Xoptions[WIDTH].'px; height:'.$Xoptions[HEIGHT].'px" align="'.$Xoptions[ALIGN].'" valign="'.$Xoptions[VALIGN].'">';
 if($name=='FRAME')
 {
  if(!$Xoptions[TALIGN]) $Xoptions[TALIGN]='left';
  if($Xoptions[TITLE]) $Xoptions[TITLE]='<span class="frame">&nbsp;'.$Xoptions[TITLE].'&nbsp;</span>';
  $Xstring.='<table height="'.$Xoptions[HEIGHT].'" width="'.$Xoptions[WIDTH].'" cellpadding="0" cellspacing="0" class="frame"><tr><td class="framea"></td><td class="frameab" align="'.$Xoptions[TALIGN].'">'.$Xoptions[TITLE].'</td><td class="frameb"></td></tr>';
  $Xstring.='<tr><td class="frameac"></td><td class="frame"><table cellpadding="'.$Xoptions[MARGE].'" cellspacing="'.$Xoptions[MARGE].'" height="100%" width="100%"><tr><td height="100%" width="100%" align="'.$Xoptions[ALIGN].'" valign="'.$Xoptions[VALIGN].'">';
 }
 if($name=='NOTEBOOK')
 {
   $Xn[NOTEBOOK]++;
   $Yb++;
   if(!$Xoptions[NAME]) $Xoptions[NAME]='notebook'.$Xn[NOTEBOOK];
   $Xtemp[NOTEBOOK][$Yb][1]=$Xoptions[NAME];
   $Xn[PAGE][$Yb]=1;
   if(!$Xoptions[PAGEON]) $Xoptions[PAGEON]=1;
   $Xtemp[NOTEBOOK][$Yb][0]=$Xoptions[PAGEON];
   $Xstring.='<table id="'.$Xoptions[NAME].'" last="'.$Xtemp[NOTEBOOK][$Yb][0].'" cellpadding="0" cellspacing="0" class="frame" width="'.$Xoptions[WIDTH].'" height="'.$Xoptions[HEIGHT].'"><tr><td class="pagea"></td><td class="pageab">';
   $tab=explode(',',$Xoptions[TITLES]);
   $Xstring.='<table cellpadding="0" cellspacing="0"><tr>';
   for($i=0; $i<count($tab); $i++)
   {
     $j=$i+1;
     if($Xtemp[NOTEBOOK][$Yb][0]==$j) $on='On'; else $on='Off';
     $Xstring.='<td id="Xpage_'.$Xoptions[NAME].'_'.$j.'a" class="pagea'.$on.'" onclick="NoteBookOnclick(\''.$Xoptions[NAME].'\', '.$j.')"></td><td id="Xpage_'.$Xoptions[NAME].'_'.$j.'ab" class="pageab'.$on.'" align="center" valign="middle" onclick="NoteBookOnclick(\''.$Xoptions[NAME].'\', '.$j.')">&nbsp;&nbsp;'.trim($tab[$i]).'&nbsp;&nbsp;</td><td id="Xpage_'.$Xoptions[NAME].'_'.$j.'b" class="pageb'.$on.'" onclick="NoteBookOnclick(\''.$Xoptions[NAME].'\', '.$j.')"></td>';
   }
   $Xstring.='</tr></table></td><td class="pageb"></td></tr><tr><td class="pageac"></td><td>';
 }
 if($name=='PAGE')
 {
   $Xstring.='<div id="Xpage_'.$Xtemp[NOTEBOOK][$Yb][1].'_'.$Xn[PAGE][$Yb].'" style="width:100%; height:100%; display:';
   if($Xtemp[NOTEBOOK][$Yb][0]==$Xn[PAGE][$Yb]) $Xstring.='true'; else $Xstring.='none';
   $Xstring.=';"><table cellpadding="'.$Xoptions[MARGE].'" cellspacing="'.$Xoptions[MARGE].'" height="100%" width="100%"><tr><td height="100%" width="100%" align="'.$Xoptions[ALIGN].'" valign="'.$Xoptions[VALIGN].'">';
   $Xn[PAGE][$Yb]++;
 }
 if($name=='CLIST')
 {
  $Xtemp='';
  $Xlasttag=$name;
  $XlastName=$Xoptions[NAME];
  $Xn[CLIST]++;
  if(!$Xoptions[NAME]) $Xoptions[NAME]='clist'.$Xn[CLIST];
  $XlastName=$Xoptions[NAME];

  if(!$Xoptions[COLUMNS]) $Xoptions[COLUMNS]=1;
  $t=explode(',', trim($Xoptions[TITLES]));
  $w=explode(',', trim($Xoptions[CWIDTH]));
  $Xtemp[0]=explode(',', trim($Xoptions[CALIGN]));
  for($i=0; $i<$Xoptions[COLUMNS]; $i++)
  {
     if($w[$i]<50) $w[$i]=50;
     if(!$w[$i]||$w[$i]<strlen($t[$i])*8+14) $w[$i]=strlen($t[$i])*8+15;
  }
  $Xtemp[1]=$w;
  if($Xoptions[WIDTH]<array_sum($w)+12) $Xoptions[WIDTH]=array_sum($w)+24;
  if($Xoptions[HEIGHT]) $Xoptions[HEIGHT]-=5;
  
  $Xstring.='<table height="'.$Xoptions[HEIGHT].'" width="'.$Xoptions[WIDTH].'" cellpadding="1" cellspacing="1" class="clist"><tr><td><div style="z-index: 0; width:'.($Xoptions[WIDTH]).'px;"><table cellpadding="0" cellspacing="0"><tr>';
  for($i=0; $i<$Xoptions[COLUMNS]; $i++) $Xstring.='<td class="cclista"></td><td class="cclistab" style="width:'.($w[$i]-12).'px; height:20px;" align="'.trim($Xtemp[0][$i]).'" valign="middle">'.trim($t[$i]).'</td><td class="cclistb"></td><td></td>';
  $Xstring.='</tr></table></div><input id="'.$Xoptions[NAME].'" name="'.$Xoptions[NAME].'" type="hidden" real="Xclist'.$Xn[CLIST].'f"><iframe id="Xclist'.$Xn[CLIST].'f" name="Xclist'.$Xn[CLIST].'f" frameborder="0" width="100%" height="'.$Xoptions[HEIGHT].'" src="'.$Xpath.'Xmind/themes/'.$Xtheme.'/inclist.php?clist='.$Xn[CLIST].'" real="'.$Xoptions[NAME].'"></iframe></td></tr></table>';

  $Xstring.='<script language="Javascript">function ClistDefault'.$Xn[CLIST].'() { document.getElementById("Xclist'.$Xn[CLIST].'f").contentWindow.document.getElementById("content").innerHTML=\'<table border=0 cellpadding="0" cellspacing="0"><tbody id="content2"><tr>';
  for($i=0; $i<$Xoptions[COLUMNS]; $i++) $Xstring.='<td style="width:6px; height:1px;"></td><td id="td'.$i.'" style="width:'.($w[$i]-12).'px; height:1px;" align="'.trim($Xtemp[0][$i]).'"></td><td style="width:6px; height:1px;"></td>';
  $Xstring.='</tr>';

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
 global $Xstring, $Xpath, $Xoptions, $Xtheme, $Xlasthandler, $defaultVars, $Xlasttag, $XlastName,
 $Xtemp, $Xn, $Xintegration, $Yb, $Xcode;

 if($name=='SCRIPT') $Xstring.=$Xlasthandler.'</script>';
 if($name=='CODE') if ($Xtemp[CODE])
 {
   session_start();
   session_register('Xcode');
   $Xcode[$Xtemp[CODE]]=$Xlasthandler;
 }
 if($name=='TBOX')$Xstring.='</table>';
 if($name=='TR')$Xstring.='</tr>';
 if($name=='TD')$Xstring.='</td>';
 if($name=='LAYER') $Xstring.='</div>';
 if($name=='FRAME') $Xstring.='</td></tr></table></td><td class="framebd"></td></tr><tr><td class="framec"></td><td class="framecd"></td><td class="framed"></td></tr></table>';
 if($name=='NOTEBOOK')
 {
  $Xstring.='</td><td class="pagebd"></td></tr><tr><td class="pagec"></td><td class="pagecd"></td><td class="paged"></td></tr></table>';
  $Yb--;
 }
 if($name=='PAGE') $Xstring.='</td></tr></table></div>';
 if($name=='LABEL') $Xstring.=XmindLabel($Xlasthandler,$Xoptions[NAME],$Xoptions[STYLE]);
 if($name=='ENTRY')
 {
  $Xoptions[ONCHANGE]=str_replace("'", "\\'", $Xoptions[ONCHANGE]);
  $Xoptions[ONCHANGE]=str_replace("'", "\\'", $Xoptions[ONBLUR]);
  $Xstring.=XmindEntry($Xtheme,$Xoptions[NAME],$Xoptions[TYPE],$Xoptions[WIDTH],$Xlasthandler,$Xoptions[ACTIVE],$Xoptions[ONCHANGE],$Xoptions[ONBLUR]);
 }
 if($name=='TEXT')
 {
  $Xoptions[ONCHANGE]=str_replace("'", "\\'", $Xoptions[ONCHANGE]);
  $Xoptions[ONCHANGE]=str_replace("'", "\\'", $Xoptions[ONBLUR]);
  $Xstring.=XmindText($Xtheme,$Xoptions[NAME], $Xoptions[WIDTH],$Xoptions[HEIGHT],$Xlasthandler,$Xoptions[ACTIVE],$Xoptions[ONCHANGE],$Xoptions[ONBLUR]);
 }
 if($name=='HIDDEN') $Xstring.=XmindHidden($Xoptions[NAME],$Xlasthandler);
 if($name=='SPIN')
 {
  $Xoptions[ONCHANGE]=str_replace("'", "\\'", $Xoptions[ONCHANGE]);
  $Xoptions[ONCHANGE]=str_replace("'", "\\'", $Xoptions[ONBLUR]);
  $Xstring.=XmindSpin($Xtheme,$Xoptions[NAME],$Xoptions[WIDTH],$Xlasthandler,$Xoptions['MIN'],$Xoptions['MAX'],$Xoptions[STEP],$Xoptions[ONCHANGE],$Xoptions[ONBLUR],$Xoptions[ACTIVE]);
 }
 if($name=='BUTTON')
 {
  $Xoptions[ONCLICK]=str_replace("'", "\\'", $Xoptions[ONCLICK]);
  $Xstring.=XmindButton($Xtheme,$Xoptions[NAME],$Xlasthandler,$Xoptions[IMAGE],$Xoptions[ONCLICK],$Xoptions[VALUE],$Xoptions[ACTIVE], $Xoptions[WIDTH]);
 }
 if($name=='TOGGLE')
 {
  $Xoptions[ONCLICK]=str_replace("'", "\\'", $Xoptions[ONCLICK]);
  $Xstring.=XmindToggle($Xtheme,$Xoptions[NAME],$Xlasthandler,$Xoptions[VALUE],$Xoptions[ONCLICK],$Xoptions[ACTIVE]);
 }
 if($name=='CHECKBOX')
 {
  $Xoptions[ONCLICK]=str_replace("'", "\\'", $Xoptions[ONCLICK]);
  $Xstring.=XmindCheckBox($Xtheme,$Xoptions[NAME],$Xoptions[VALUE],$Xoptions[ONCLICK],$Xoptions[ACTIVE]);
 }
 if($name=='RADIO')
 {
  $Xoptions[ONCLICK]=str_replace("'", "\\'",$Xoptions[ONCLICK]);
  $Xstring.=XmindRadio($Xtheme,$Xoptions[NAME],$Xlasthandler,$Xoptions[VALUE],$Xoptions[ONCLICK],$Xoptions[ACTIVE]);
 }
 if($name=='PROGRESSBAR')$Xstring.=XmindProgressBar($Xtheme,$Xoptions[NAME],$Xoptions[WIDTH],$Xoptions[VALUE]);
 if($name=='IMAGE')$Xstring.=XmindImage($Xoptions[NAME],$Xoptions[SRC],$Xoptions[WIDTH],$Xoptions[HEIGHT]);
 if($name=='DRAWINGAREA')$Xstring.=XmindDrawingArea($Xtheme,$Xoptions[NAME],$Xoptions[WIDTH],$Xoptions[HEIGHT],$Xoptions[SRC]);
 if($name=='CLIST')
 {
  $Xlasttag='';
  $Xstring.='</tbody></table>\'; }</script>';
 }
 if($name=='OPTION')
 {
   if($Xlasttag='CLIST')
   {
    $Xstring.='<tr onclick="parent.ClistOnClick(this, \\\''.$XlastName.'\\\', \\\''.trim($Xlasthandler).'\\\')">';
    $t=explode(',',trim($Xlasthandler));
    $i=0;
    foreach($t as $t2)
    {
     $n=round($Xtemp[1][$i]/8-2);
     if(strlen($t2)>$n)
     {
      $t2{$n}=',';
      list($t2,)=explode(',',$t2);
     }
     $Xstring.='<td></td><td  align="'.trim($Xtemp[0][$i]).'">&nbsp;'.trim($t2).'</td><td></td>';
     $i++;
    }
    $Xstring.='</tr>';
   }

 }

 if($name=='XMIND')
 {
  if($Xn[XMIND]==1)
  {
   $Xstring.='</form><div style="position: absolute; visibility: hidden; display:none;"><table><tr>';
   $tab=array('togglea','toggleb','toggleab','toggleaOn','togglebOn','toggleabOn','buttonaOn','buttonbOn','buttoncOn','buttondOn','buttonabOn','buttonacOn','buttonbdOn','buttoncdOn','buttonabcdOn','spinbutton1On','spinbutton2On');
   foreach($tab as $t) $Xstring.='<td class="'.$t.'">  </td>';
   $Xstring.='</tr></table></div><script language="Javascript">window.onload=new Function("SetDefaultValues()");</script>';
  }
  if($Xintegration!='plain') $Xstring.='</body></html>';
 }

 $Xlasttag='';
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
