<?php

/*

 Xmind project (ActionScript module)
 Auteur : Thomas Favennec
 version  0.1.0 beta
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



 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 header("Cache-Control: no-store, no-cache, must-revalidate");
 header("Cache-Control: post-check=0, pre-check=0", false);
 header("Pragma: no-cache");

 


 // situe l'emlacement du répertoire Xmind
 function XmindSetPath($path)
 {
  global $Xpath;
  if(!file_exists($path.'/Xmind/Xmind.php'))  die("Xmind error : Impossible de situer le répertoire Xmind sur $path .");
  if($path{strlen($path)-1}!='/') $path.='/';
  $Xpath=$path;
 }



 
 // démarre l'ActionScript
 function XmindBeginAction()
 {
   echo '<html><body><script language="Javascript">';
 }
 

 // Vide le buffer de sortie
 // fait éventuellement une pause de $seconde
 function XmindIteration($seconde=0)
 {
  echo '</script><script language="Javascript">';
  ob_flush();
  flush();
  if($seconde) sleep($seconde);
 }




 // change l'url principale
 function XmindUrlChange($url)
 {
   echo 'parent.window.location="',$url,'";';
 }


 // envoi un message a l'écran
 function XmindAlert($text)
 {
   echo 'alert("',$text,'");';
 }
 
 

 // créé une timeout actionscript
 // time est en secondes
 function XmindTimeoutStart($url, $time=1)
 {
  echo'if(!parent.document.getElementById("Xtaction"))
  {
   var node=parent.document.createElement("iframe");
   node.setAttribute("id","Xtaction");
   node.style.border=0;
   node.style.width=0;
   node.style.height=0;
   parent.document.body.appendChild(node);
  }
  parent.timeOutPage="',$url,'";
  parent.timeOutTime=',($time*1000),';
  setTimeout(parent.actionTimeout, "',$time,'")';
 }


 // stop un timeout le cour
 function  XmindTimeoutStop()
 {
  echo 'parent.timeOutPage=0;';
 }




 // Change la page d'un notebook
 function XmindNotebookSetPage($name, $page)
 {
   echo 'var a=parent.document.getElementById(\'',$name,'\');
    if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
    else
    {
     var b=a.getAttribute("last");
     if(b!="',$page,'"&&parent.document.getElementById("Xpage_',$name,'_',$page,'a"))
     {
      parent.document.getElementById("Xpage_',$name,'_',$page,'a").className="pageaOn";
      parent.document.getElementById("Xpage_',$name,'_',$page,'ab").className="pageabOn";
      parent.document.getElementById("Xpage_',$name,'_',$page,'b").className="pagebOn";
      if(parent.document.getElementById("Xpage_',$name,'_',$page,'")) parent.document.getElementById("Xpage_',$name,'_',$page,'").style.display="inline";
      if(parent.document.getElementById("Xpage_',$name,'_"+b)) parent.document.getElementById("Xpage_',$name,'_"+b).style.display="none";
      parent.document.getElementById("Xpage_',$name,'_"+b+"a").className="pageaOff";
      parent.document.getElementById("Xpage_',$name,'_"+b+"ab").className="pageabOff";
      parent.document.getElementById("Xpage_',$name,'_"+b+"b").className="pagebOff";
      parent.document.getElementById("',$name,'").setAttribute("last",',$page,');
     }
    }';
 }




 // Change le texte d'un label
 function XmindLabelSetText($name, $label)
 {
   echo 'var a=parent.document.getElementById(\'',$name,'\');
    if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
    else a.innerHTML="',$label,'";';
 }




  // Change le texte d'un bouton
  function XmindButtonSetLabel($name, $text)
 {
   echo 'var a=parent.document.getElementById(\'',$name,'\');
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else parent.document.getElementById(a.getAttribute("realname")+"label").innerHTML="',$text,'&nbsp;&nbsp;";';
 }



 // Active ou désactive un bouton
 function XmindButtonSetActive($name, $active)
 {
   global $Xtheme, $Xpath;
   
   if($active=='0') $no='no';
   
   echo 'var a=parent.document.getElementById(\'',$name,'\');
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else
   {
    var button=a.getAttribute("realname");
    parent.document.getElementById(button+"abcd").className="buttonabcd',$no,'";
    parent.document.getElementById(button+"a").className="buttona',$no,'";
    parent.document.getElementById(button+"ab").className="buttonab',$no,'";
    parent.document.getElementById(button+"b").className="buttonb',$no,'";
    parent.document.getElementById(button+"c").className="buttonc',$no,'";
    parent.document.getElementById(button+"cd").className="buttoncd',$no,'";
    parent.document.getElementById(button+"d").className="buttond',$no,'";
    parent.document.getElementById(button+"ac").className="buttonac',$no,'";
    parent.document.getElementById(button+"bd").className="buttonbd',$no,'";
    parent.document.getElementById(button+"label").className="',$no,'";
    a.setAttribute("active","',$active,'");
   }';
 }



 // change l'image d'un bouton
 function XmindButtonSetImage($name, $image)
 {
   echo 'var a=parent.document.getElementById(\'',$name,'\');
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else if(!parent.document.getElementById(a.getAttribute("realname")+"img")) alert("Xmind actionScript error : Le bouton [',$name,'] ne contient pas d\'image.");
   else parent.document.getElementById(a.getAttribute("realname")+"img").src="',$image,'";';
 }



 
 // attribut une valeur à un objet editable (entry, spin, hidden et text)
 function XmindEditableSetValue($name, $value)
 {
   $value=str_replace("\n", '\n', $value);
   echo 'var a=parent.document.getElementById(\'',$name,'\');
    if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
    else a.value="',$value,'"';
 }

 // Active ou désactive un objet editable
 function XmindEditableSetActive($name, $active)
 {
  if($active=='0')
  {
   $read='a.readOnly="true"';
   $no='No';
   }
   else $read='a.readOnly=""';
   
   echo 'var a=parent.document.getElementById(\'',$name,'\');
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else
   {
    ',$read,';
    a.className="entry',$no,'";
   }';
 }






 // attribut une valeur à un text
 // $value doit être numéric
 function XmindSpinSetValue($name, $value)
 {
   if(!is_numeric($value)) echo 'alert("Xmind actionScript error : valeur interdite dans XmindSpinSetValue");';
   else echo 'var a=parent.document.getElementById(\'',$name,'\');
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else a.value="',$value,'";';
 }




  // Change l'état d'un toggle
  // value peut être 0 ou 1
  function XmindToggleSetState($name, $value)
 {
   global $Xtheme, $Xpath;

   if($value!=0&&$value!=1) echo 'alert("Xmind actionScript error : valeur interdite dans XmindToggleSetState");';
   else
   {
    if($value) $on='On'; else $on='';
    echo 'var a=parent.document.getElementById(\'',$name,'\');
    if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
    else
    {
       a.value="'.$value.'";
       parent.document.getElementById(a.getAttribute("realname")+"_a").className="togglea',$on,'";
       parent.document.getElementById(a.getAttribute("realname")+"_ab").className="toggleab',$on,'";
       parent.document.getElementById(a.getAttribute("realname")+"_b").className="toggleb',$on,'";
    }';

   }

 }


 // Active ou désactive un toggle
 function XmindToggleSetActive($name, $active)
 {
   global $Xtheme, $Xpath;

   if($active=='0') $no='No';

   echo 'var a=parent.document.getElementById(\'',$name,'\');
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else
   {
    if(a.value==1) var on="On"; else var on="";
    parent.document.getElementById(a.getAttribute("realname")+"_a").className="togglea"+on+"',$no,'";
    parent.document.getElementById(a.getAttribute("realname")+"_ab").className="toggleab"+on+"',$no,'";
    parent.document.getElementById(a.getAttribute("realname")+"_b").className="toggleb"+on+"',$no,'";
    a.setAttribute("active","',$active,'");
   }';
 }





 // Change le texte d'un toggle
 function XmindToggleSetLabel($name, $text)
 {
   XmindButtonSetLabel($name, $text);
 }






  // Change l'état d'une cas à cocher
  // value peut être 0 ou 1
 function XmindCheckBoxSetState($name, $value)
 {
   global $Xtheme, $Xpath;
   
   if($value!=0&&$value!=1) echo 'alert("Xmind actionScript error : valeur interdite dans XmindCheckBoxSetState");';
   else
   {
    if($value) $on='_on'; else $on='_off';
    echo 'var a=parent.document.getElementById(\'',$name,'\');
     if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
     else
     {
        a.value="',$value,'";
        parent.document.getElementById(a.getAttribute("realname")).src="',$Xpath,'Xmind/themes/',$Xtheme,'/check',$on,'.png";
     }';

   }

 }



  // Active ou désactive une case à cocher
 function XmindCheckBoxSetActive($name, $active)
 {
   global $Xtheme, $Xpath;

  if($active!='0') $active=1;
  else $no='no';

  echo 'var a=parent.document.getElementById(\'',$name,'\');
  if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
  else
  {
    var on;
    if(a.value==1) on="_on";
    else on="_off";
    a.setAttribute("active", "',$active,'");
    parent.document.getElementById(a.getAttribute("realname")).src="',$Xpath,'Xmind/themes/',$Xtheme,'/check"+on+"',$no,'.png";
  }';

 }






 // Change la valeur d'un radiobutton
 // value doit exister : <radio name="...">value</radio>
 function XmindRadioSetValue($name, $value)
 {
   global $Xtheme, $Xpath;

   if($value) $on='_on'; else $on='_off';
   echo 'var a=parent.document.getElementById(\'',$name,'\');
   var ok=0;
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else
   {
     var liste=parent.document.getElementsByName("radio_',$name,'");
     if(liste)
     for(i=0; liste[i]; i++)
     {
       liste[i].src="',$Xpath,'Xmind/themes/',$Xtheme,'/radio_off.png";
       if(liste[i].getAttribute("realvalue")=="',$value,'")
       {
        liste[i].src="',$Xpath,'Xmind/themes/',$Xtheme,'/radio_on.png";
        a.value="',$value,'";
        ok=1;
       }
     }
     if(!ok) alert("Xmind actionScript error : <RADIO name=\"',$name,'\">',$value,'</RADIO> introuvable.");

   }';

 }



  // Active ou désactive un radiobutton
 function XmindRadioSetActive($name, $active)
 {
   global $Xtheme, $Xpath;

  if(!$active) $no='no';

  echo 'var a=parent.document.getElementById(\'',$name,'\');
  if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
  else
  {
   var liste=parent.document.getElementsByName("radio_',$name,'");
   var img;
   if(liste) for(i=0; liste[i]; i++)
   {
    img=liste[i].src;
    img=img.replace("no.png","");
    img=img.replace(".png","");
    liste[i].src=img+"',$no,'.png";
    liste[i].setAttribute("active","',$active,'");
   }
  }';

 }







 // Change la position d'une progressBar (en %)
 function XmindProgressBarSetValue($name, $position=0)
 {
   if($position>100) $position=100;
   if($position<0) $position=0;
   
   echo 'var a=parent.document.getElementById(\'X',$name,'_tab\');
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else
   {
    var w=a.getAttribute("real");
    var w2=Math.round(',$position,'*(w-10)/100);
    var b=parent.document.getElementById(\'X',$name,'_td1\');
    var c=parent.document.getElementById(\'X',$name,'_td2\');
    var d=parent.document.getElementById(\'X',$name,'_td3\');
    var w0=b.style.width;
    if(!',$position,')
    {
     b.style.width=w0;
     c.style.width=0;
     d.style.width=w0;
     a.style.visibility="hidden";
    }
    else
    {
     b.style.width=w0;
     c.style.width=w2;
     d.style.width=w0;
     a.style.visibility="visible";
    }
   }';

 }





 // ajoute une entrée dans la liste $name
 function XmindClistAppend($name, $table)
 {
  if(!is_array($table)) $table=explode(',',$table);
  echo 'var a=parent.document.getElementById("',$name,'");
  if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
  else
  {
   var a2=parent.document.getElementById(a.getAttribute("real")).contentWindow;
   var lastClistClicked=a2.lastClistClicked;
   if(lastClistClicked) lastClistClicked.className="inclist";
   var mactual=a2.document.getElementById("content2").innerHTML;
   var o;';
   
   $i=0;
   if($table)
   foreach($table as $t)
   {
    echo 'o=a2.document.getElementById("td',$i,'");
    var w',$i,'=o.style.width.replace("px","");
    var t',$i,'="',trim($t),'";
    if(t',$i,'.length>w',$i,'/8-2) t',$i,'=t',$i,'.slice(0,Math.round(w',$i,'/8)-2);';
    $i++;
   }

   $i=0;
   if($table)
   foreach($table as $t)
   {
    $td.='<td></td><td align=\'+a2.document.getElementById("td'.$i.'").getAttribute("align")+\'>&nbsp;\'+t'.$i.'+\'</td><td></td>';
    if($i>0) $handler.=',';
    $handler.=$t;
    $i++;
   }

   echo 'var mnew=\'<tr onclick="parent.ClistOnClick(this, \\\'',$name,'\\\', \\\'',$handler,'\\\')">',$td,'</tr>\';
   a2.document.getElementById("content").innerHTML="<table border=0 cellpadding=\'0\' cellspacing=\'0\'><tbody id=content2>"+mactual+mnew+"</tbody></table>";
   }';
   
 }





 // efface une clist
 function XmindClistClear($name)
 {
  echo 'var a=parent.document.getElementById("',$name,'");
  if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
  else
  {
   var a2=parent.document.getElementById(a.getAttribute("real")).contentWindow;
   a2.lastClistClicked=\'\';
   var tab=a2.document.getElementsByTagName("tr");
   var node=a2.document.getElementById("content2");
   var j=tab.length;
   if(tab.length>1) for(var i=0; i<j; i++) if(tab.item(1)) node.removeChild(tab.item(1));
  }';

 }










 function XmindImageSetSource($name, $source)
 {
   echo 'var a=parent.document.getElementById("',$name,'");
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else a.src="',$source,'";';
 }




 function XmindImageSetSize($name, $w, $h)
{
   echo 'var a=parent.document.getElementById("',$name,'");
   if(!a) alert("Xmind actionScript error : Objet [',$name,'] introuvable.");
   else
   {
    a.width=',$w,';
    a.height=',$h,';
   }';
}






 // charge un document svg dans un objet drawingarea
 function XmindDrawSetSource($drawingarea, $src)
 {
   if(!file_exists($src)) echo 'alert("Xmind actionScript error : ',$src,' est introuvable.");';
   else echo 'var a=parent.document.getElementById("X',$drawingarea,'parent");
   if(!a) alert("Xmind actionScript error : Objet [',$drawingarea,'] introuvable.");
   else
   {
     var b=parent.document.getElementById("',$drawingarea,'");
     var w=b.getAttribute("width");
     var h=b.getAttribute("height");
     a.innerHTML="<embed id=\''.$drawingarea.'\' src=\''.$src.'\' width=\'"+w+"\' height=\'"+h+"\' pluginspage=\'http://www.adobe.com/svg/viewer/install/main.html\' type=\'image/svg+xml\'/>";
   }';

 }


 // trace un rectangle dans un objet drawingarea
 function XmindDrawRectangle($drawingarea, $x, $y, $width, $height, $style='stroke:black;fill:white')
 {
   echo 'var a=parent.document.getElementById("',$drawingarea,'");
   if(!a) alert("Xmind actionScript error : Objet [',$drawingarea,'] introuvable.");
   else
   {
    var b=a.getSVGDocument();
    node=b.createElement("rect");
    node.setAttribute("x","',$x,'");
    node.setAttribute("y","',$y,'");
    node.setAttribute("width","',$width,'");
    node.setAttribute("height","',$height,'");
    node.setAttribute("style","',$style,'");
    if(b.getElementById("content")) b.getElementById("content").appendChild(node);
    else alert("Xmind actionScript error : Le document svg doit contenir un élément parent <g id=\\"content\\"...");
   }';

 }
 

 
 // trace un cercle dans un objet drawingarea
 function XmindDrawCircle($drawingarea, $x, $y, $r, $style='stroke:black;fill:white')
 {
   echo 'var a=parent.document.getElementById("',$drawingarea,'");
   if(!a) alert("Xmind actionScript error : Objet [',$drawingarea,'] introuvable.");
   else
   {
    var b=a.getSVGDocument();
    node=b.createElement("circle");
    node.setAttribute("cx","',$x,'");
    node.setAttribute("cy","',$y,'");
    node.setAttribute("r","',$r,'");
    node.setAttribute("style","',$style,'");
    if(b.getElementById("content")) b.getElementById("content").appendChild(node);
    else alert("Xmind actionScript error : Le document svg doit contenir un élément parent <g id=\\"content\\"...");
   }';

 }



 // trace une ligne dans un objet drawingarea
 function XmindDrawLine($drawingarea, $x1, $y1, $x2, $y2, $style='stroke:black;')
 {
   echo 'var a=parent.document.getElementById("',$drawingarea,'");
   if(!a) alert("Xmind actionScript error : Objet [',$drawingarea,'] introuvable.");
   else
   {
    var b=a.getSVGDocument();
    node=b.createElement("line");
    node.setAttribute("x1","',$x1,'");
    node.setAttribute("y1","',$y1,'");
    node.setAttribute("x2","',$x2,'");
    node.setAttribute("y2","',$y2,'");
    node.setAttribute("style","',$style,'");
    if(b.getElementById("content")) b.getElementById("content").appendChild(node);
    else alert("Xmind actionScript error : Le document svg doit contenir un élément parent <g id=\\"content\\"...");
   }';

 }



 // trace une ligne dans un objet drawingarea
 function XmindDrawPolygon($drawingarea, $points, $style='stroke:black;fill:white')
 {
   foreach($points as $p)
   {
     $t.=$p;
     if($i) $t.=' ';
     else $t.=',';
     
     if(!$i) $i=1;
     else $i=0;
   }
   
   echo 'var a=parent.document.getElementById("',$drawingarea,'");
   if(!a) alert("Xmind actionScript error : Objet [',$drawingarea,'] introuvable.");
   else
   {
    var b=a.getSVGDocument();
    node=b.createElement("polygon");
    node.setAttribute("points","',trim($t),'");
    node.setAttribute("style","',$style,'");
    if(b.getElementById("content")) b.getElementById("content").appendChild(node);
    else alert("Xmind actionScript error : Le document svg doit contenir un élément parent <g id=\\"content\\"...");
   }';

 }



 // trace du texte dans un objet drawingarea
 function XmindDrawText($drawingarea, $x, $y, $text, $style='')
 {
   echo 'var a=parent.document.getElementById("'.$drawingarea.'");
   if(!a) alert("Xmind actionScript error : Objet ['.$drawingarea.'] introuvable.");
   else
   {
    var b=a.getSVGDocument();
    node=b.createElement("text");
    node.setAttribute("x","',$x,'");
    node.setAttribute("y","',$y,'");
    node.setAttribute("style","',$style,'");
    var texte=b.createTextNode("',$text,'");
    node.appendChild(texte);
    if(b.getElementById("content")) b.getElementById("content").appendChild(node);
    else alert("Xmind actionScript error : Le document svg doit contenir un élément parent <g id=\\"content\\"...");
   }';

 }



 // efface un objet drawingarea
 function XmindDrawClear($drawingarea)
{
   echo 'var a=parent.document.getElementById("',$drawingarea,'");
   if(!a) alert("Xmind actionScript error : Objet [',$drawingarea,'] introuvable.");
   else
   {
    var b=a.getSVGDocument();
    var node=b.getElementById("content");
    if(!node) alert("Xmind actionScript error : Le document svg doit contenir un élément parent <g id=\\"content\\"...");
    else
    {
      var layer=node.childNodes;
      var nombre=layer.length;
      for(i=0; i<nombre; i++)
      {
       node.removeChild(layer.item(0));
       layer=node.childNodes;
      }
     }
    }';
}













 function XmindEndAction()
 {
  echo '</script></body></html>';
 }



 

?>
