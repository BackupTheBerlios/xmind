<?php

/*

 Xmind project (widget core)
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

*/


function XmindLabel($label, $name, $style='')
{
 global $Xn;
 $n=++$Xn[LABEL];
 if(!$name) $name='label'.$n;
 
 $label=str_replace("\\n", "<br>", $label);
 if($style) $style=' style="'.$style.'"';
 return('<span id="'.$name.'"'.$style.'>'.$label.'&nbsp;</span>');
}





function XmindButton($theme, $name, $label, $image='', $onclick='', $value='', $active=1, $width='')
{
 global $Xpath, $Xn;
 $n=++$Xn[BUTTON];
 if(!$name) $name='button'.$n;

 if($active!='0') $active=1;
 else $no='No';

 if($image) $image='<img id="Xbutton'.$n.'img" src="'.$image.'">';
 return('<table style="text-align: left;" onclick="buttonOnClick(\'Xbutton'.$n.'\', \''.$onclick.'\', \''.$name.'\')" onselectstart="return false" border="0" cellpadding="0" cellspacing="0">
 <tr><td id="Xbutton'.$n.'a" class="buttona'.$no.'"></td>
 <td id="Xbutton'.$n.'ab" class="buttonab'.$no.'"></td>
 <td id="Xbutton'.$n.'b" class="buttonb'.$no.'"></td></tr>
 <tr><td id="Xbutton'.$n.'ac" class="buttonac'.$no.'"></td>
 <td id="Xbutton'.$n.'abcd" class="buttonabcd'.$no.'" width="'.$width.'" align="center"><table align="center"><tr><td>&nbsp;'.$image.'</td><td id="Xbutton'.$n.'label" class="'.$no.'">'.$label.'&nbsp;&nbsp;</td></tr></table></td>
 <td id="Xbutton'.$n.'bd" class="buttonbd'.$no.'"></td></tr>
 <tr><td id="Xbutton'.$n.'c" class="buttonc'.$no.'"></td>
 <td id="Xbutton'.$n.'cd" class="buttoncd'.$no.'"></td>
 <td id="Xbutton'.$n.'d" class="buttond'.$no.'"></td></tr>
 </table><input id="'.$name.'" name="'.$name.'" type="hidden" value="'.$value.'" realname="Xbutton'.$n.'" active="'.$active.'">
 <script language="Javascript">defaultname.push("'.$name.'");defaultvar.push("'.$value.'");</script>');
}



function XmindToggle($theme, $name, $label, $default=0, $onclick='', $active=1)
{
 global $Xpath, $Xn;
 $n=++$Xn[TOGGLE];
 if(!$name) $name='toggle'.$n;

 if($active!='0') $active=1;
 else $no='No';

 if($default) $on='On';

 return('<table style="text-align: left;" onclick="toggleOnClick(\'XToggle'.$n.'\', \''.$name.'\', \''.$onclick.'\')" onselectstart="return false" class="button" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td id="XToggle'.$n.'_a" class="togglea'.$on.$no.'"></td>
      <td id="XToggle'.$n.'_ab" class="toggleab'.$on.$no.'">&nbsp; '.$label.'&nbsp;&nbsp;</td>
      <td id="XToggle'.$n.'_b" class="toggleb'.$on.$no.'"></td>
    </tr>
  </table><div style="z-index: 0; position: absolute; visibility: hidden;">
  <input id="'.$name.'" name="'.$name.'" value="'.$default.'" realname="XToggle'.$n.'" active="'.$active.'"></div>
  <script language="Javascript">defaultname.push("'.$name.'");defaultvar.push("'.$default.'");</script>');

}



function XmindEntry($theme, $name, $type='text', $size=135, $default='', $active=1, $onchange='', $onblur='')
{
 global $Xpath, $Xn;
 $n=++$Xn[ENTRY];
 if(!$name) $name='entry'.$n;
 if(!$size) $size=135;
 
 if($type=='password') $type='password'; else $type='text';
 
 if($onblur) $onblur=' onblur="activeScript(\''.$onblur.'\')"';
 if($onchange) $onchange=' onkeyup="activeScript(\''.$onchange.'\')"';
 if($active=='0')
 {
  $disablet='readonly="true"';
  $no='no';
 }

 return('<table style="text-align: left; height: 2px;" class="entry" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="entrya"></td>
      <td class="entryab"><input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$default.'" '.$disablet.' class="entry'.$no.'"'.$onblur.$onchange.' style="width:'.$size.';"></td>
      <td class="entryb"></td>
    </tr></table><script language="Javascript">defaultname.push("'.$name.'");defaultvar.push("'.$default.'");</script>');
}




function XmindHidden($name, $default='')
{
 global $Xn;
 $n=++$Xn[HIDDEN];
 if(!$name) $name='hidden'.$n;

 return('<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$default.'">
 <script language="Javascript">defaultvar.push("'.$name.'");</script>');
}





function XmindText($theme, $name, $sizex=135, $sizey=50, $default='', $active=1, $onchange='', $onblur='')
{
 global $Xpath, $Xn;
 $n=++$Xn[TEXT];
 if(!$name) $name='text'.$n;
 if(!$sizex) $sizex=135;
 if(!$sizey) $sizey=50;
 
 if($onblur) $onblur=' onblur="activeScript(\''.$onblur.'\')"';
 if($onchange) $onchange=' onkeyup="activeScript(\''.$onchange.'\')"';
 if($active=='0')
 {
  $disablet='readonly="true"';
  $no='No';
 }

 return('<table style="text-align: left; height: 2px;" class="entry" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="texta"></td><td class="textab"></td><td class="textb"></td></tr>
      <tr><td class="textac"></td><td class="textabcd"><textarea id="'.$name.'" name="'.$name.'" class="entry'.$no.'" '.$disablet.$onblur.$onchange.' style="width:'.$sizex.'; height:'.$sizey.';">'.XmindParseDefaultText($default).'</textarea></td><td class="textbd"></td></tr>
      <tr><td class="textc"></td><td class="textcd"></td><td class="textd"></td>
    </tr>
</table><script language="Javascript">defaultname.push("'.$name.'");defaultvar.push("'.XmindParseDefaultText($default).'");</script>');

}

// corrige le texte généralement entré par défaut dans textarea
function XmindParseDefaultText($text)
{
  $text=str_replace("\\n", "\n", $text);
  return($text);
}






function XmindCheckBox($theme, $name, $default=0, $onclick='', $active=1)
{
 global $Xpath, $Xn;
 $n=++$Xn[CHECKBOX];

 if($active!='0') $active=1;
 else $no='no';

 if(!$name) $name='checkbox'.$n;
 if($default) $on='_on'; else $on='_off';

 return('<img id="Xcheckbox'.$n.'" src="'.$Xpath.'Xmind/themes/'.$theme.'/check'.$on.$no.'.png" onClick="checkBoxOnclick(\'Xcheckbox'.$n.'\', \''.$name.'\', \''.$onclick.'\')">
 <div style="z-index: 0; position: absolute; visibility: hidden;"><input id="'.$name.'" name="'.$name.'" value="'.$default.'" realname="Xcheckbox'.$n.'" active="'.$active.'"></div>
 <script language="Javascript">defaultname.push("'.$name.'");defaultvar.push("'.$default.'");</script>');

}



function XmindRadio($theme, $name, $value='', $default=0, $onclick='', $active=1)
{

 global $Xpath, $Xn, $XmindListRadio, $XmindActiveRadio;
 $n=++$Xn[RADIO];

 if(isset($XmindActiveRadio[$name])) $active=$XmindActiveRadio[$name];
 if($active!='0') $active=1;
 else $no='no';
 $XmindActiveRadio[$name]=$active;

 if($default)
 {
   $on='_on';
   $defaultvalue=$value;
 }
 else $on='_off';
 if(!$XmindListRadio||array_search($name, $XmindListRadio)===FALSE)
 {
   $input='<div style="z-index: 0; position: absolute; visibility: hidden;"><input id="'.$name.'" name="'.$name.'" value="'.$defaultvalue.'"></div>';
 }
 $XmindListRadio[]=$name;
 return('<img name="radio_'.$name.'" id="Xradio'.$n.'" src="'.$Xpath.'Xmind/themes/'.$theme.'/radio'.$on.$no.'.png" onClick="radioOnclick(\'Xradio'.$n.'\', \''.$name.'\', \''.$onclick.'\')" realvalue="'.$value.'" active="'.$active.'">'.$input.'&nbsp;
 <script language="Javascript">defaultname.push("'.$name.'");defaultvar.push("'.$defaultvalue.'");</script>');

}






function XmindSpin($theme, $name, $size=127, $default, $min=0, $max=9999, $step=1, $onchange='', $onblur='', $active=1)
{
 global $Xpath, $Xn;
 $n=++$Xn[SPIN];

 if(!$size) $size=127;
 if(!$min) $min=0;
 if(!$max) $max=9999;
 if(!$step) $step=1;
 if(!$name) $name='spin'.$n;
 if($active=='0')
 {
  $disablet=' readonly="true"';
  $no='no';
 }

 if(!is_numeric($default)) $default=0;
 if(!is_numeric($min)) $default=$min;
 if(!is_numeric($max)) $default=$max;
 if(!is_numeric($step)) $Xstep=1;
 if($default<$min) $default=$min;
 if($default>$max) $default=$max;

 if($onblur) $onblur=' onblur="activeScript(\''.$onblur.'\')"';

 return('<table style="text-align: left; height: 2px;" class="entry" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="entrya"></td>
      <td class="entryab"><input id="'.$name.'" name="'.$name.'" value="'.$default.'" class="entry'.$no.'"'.$onblur.$disablet.' style="width:'.$size.';"></td>
      <td style="height: 25px;">
      <img id="Xspinbutton1_'.$n.'" src="'.$Xpath.'Xmind/themes/'.$theme.'/spinbutton1.png" onclick="spinOnClick(\'Xspinbutton1_'.$n.'\', \''.$name.'\', 1, '.$min.', '.$max.', '.$step.', \''.$onchange.'\')"><br>
      <img src="'.$Xpath.'Xmind/themes/'.$theme.'/spinbutton12.png"><br>
      <img id="Xspinbutton2_'.$n.'" src="'.$Xpath.'Xmind/themes/'.$theme.'/spinbutton2.png" onclick="spinOnClick(\'Xspinbutton2_'.$n.'\', \''.$name.'\', 2, '.$min.', '.$max.', '.$step.', \''.$onchange.'\')"></td>
    </tr>
</table><script language="Javascript">defaultname.push("'.$name.'");defaultvar.push("'.$default.'");</script>');

}







function XmindProgressBar($theme, $name, $width, $value=0)
{
 global $Xpath, $Xn;
 $n=++$Xn[PROGRESSBAR];
 if(!$name) $name='progressbar'.$n;

 if($value<0) $value=0;
 if($value>100) $value=100;
 if($value)
 {
  $value=str_replace('%','',$value);
  $value=round($value*($width-10)/100);
  $vis='visible';
 }
 else $vis='hidden';

  return('<table border="0" cellpadding="0" cellspacing="0" valign="middle" align="left">
    <tr>
      <td class="progressa"></td>
      <td class="progressab" style="width:'.$width.'">
        <table id="X'.$name.'_tab" style="height: 20px; visibility: '.$vis.'" border="0" real="'.$width.'" cellpadding="0" cellspacing="0">
        <tr><td id="X'.$name.'_td1" class="progress2a"></td>
        <td id="X'.$name.'_td2" class="progress2ab" style="width: '.$value.'px;"></td>
        <td id="X'.$name.'_td3" class="progress2b"></td></tr></table>
      <td class="progressb"></td>
    </tr></table>');
}






function XmindImage($name, $src, $w='', $h='')
{
 global $Xn;
 $n=++$Xn[IMAGE];
 if(!$name) $name='image'.$n;
 
 if($w!='') $taille=' width="'.$w.'" height="'.$h.'"';
 return('<img id="'.$name.'" src="'.$src.'"'.$taille.'>');
}




function XmindDrawingArea($theme, $name, $w=100, $h=100, $src='')
{
 global $Xpath, $Xn;
 $n=++$Xn[DRAWINGAREA];
 if(!$name) $name='drawingarea'.$n;
 
 if(!$src) $src=$Xpath.'Xmind/themes/'.$theme.'/drawingarea.svg';
 else if(!file_exists($src)) die("Xmind error : Impossible d'ouvrir le fichier $src");
 return('<div id="X'.$name.'parent"><embed id="'.$name.'" src="'.$src.'" width="'.$w.'" height="'.$h.'" pluginspage="http://www.adobe.com/svg/viewer/install/main.html" type="image/svg+xml"/></div>');
}






?>
