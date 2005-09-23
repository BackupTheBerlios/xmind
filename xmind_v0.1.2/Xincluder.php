<?php

 /*

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

 include('XmindActionScript.php');
 session_start();
 if($f)
 {
  XmindBeginAction();
  if($Xcode[$f]) eval($Xcode[$f]);
  else
  {
   echo 'alert("Xmind error : Aucune fonction [',$f,'] ne semble définie.\nVérifiez que <code name=\"',$f,'\" existe et que les sessions PHP sont activées.");';
  }
  XmindEndAction();
  
 }





?>
