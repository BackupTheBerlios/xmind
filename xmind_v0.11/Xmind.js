
// Xmind Javascript Core
// Auteur : Thomas Favennec
// version IE/Mozilla 0.1.0 beta



var comonVar=Array();
var timeOutPage=0;
var timeOutTime=0;


function SetDefaultValues(name, value)
{
  document.getElementById(name).value=value;
}


function activeScript(action)
{
 var tab=action.split(":");
 if(!tab[1])
 {
  document.forms[0].action=tab[0];
  document.forms[0].target="Xaction";
  document.forms[0].submit();
 } else if(tab[0].toLowerCase()=="link")
 {
  document.forms[0].action=tab[1];
  document.forms[0].target='';
  document.forms[0].submit();
 } else if(tab[0].toLowerCase()=="javascript") eval(tab[1]);

}


function actionTimeout()
{
 if(timeOutPage)
 {
  document.getElementById('Xtaction').src=timeOutPage;
  setTimeout(actionTimeout, timeOutTime);
 }
}


function buttonOnClick(button, action, real)
{
 if(document.getElementById(real).getAttribute("active")==1)
 {
  document.getElementById(button+'abcd').className="buttonabcdOn";
  document.getElementById(button+'a').className="buttonaOn";
  document.getElementById(button+'ab').className="buttonabOn";
  document.getElementById(button+'b').className="buttonbOn";
  document.getElementById(button+'c').className="buttoncOn";
  document.getElementById(button+'cd').className="buttoncdOn";
  document.getElementById(button+'d').className="buttondOn";
  document.getElementById(button+'ac').className="buttonacOn";
  document.getElementById(button+'bd').className="buttonbdOn";

  comonVar[0]=document.getElementById(button+'a');
  comonVar[1]="buttona";
  comonVar[2]=document.getElementById(button+'ab');
  comonVar[3]="buttonab";
  comonVar[4]=document.getElementById(button+'b');
  comonVar[5]="buttonb";
  comonVar[6]=document.getElementById(button+'c');
  comonVar[7]="buttonc";
  comonVar[8]=document.getElementById(button+'cd');
  comonVar[9]="buttoncd";
  comonVar[10]=document.getElementById(button+'d');
  comonVar[11]="buttond";
  comonVar[12]=document.getElementById(button+'ac');
  comonVar[13]="buttonac";
  comonVar[14]=document.getElementById(button+'bd');
  comonVar[15]="buttonbd";
  comonVar[16]=document.getElementById(button+'abcd');
  comonVar[17]="buttonabcd";

  setTimeout("comonVar[0].className=comonVar[1]", 200);
  setTimeout("comonVar[2].className=comonVar[3]", 200);
  setTimeout("comonVar[4].className=comonVar[5]", 200);
  setTimeout("comonVar[6].className=comonVar[7]", 200);
  setTimeout("comonVar[8].className=comonVar[9]", 200);
  setTimeout("comonVar[10].className=comonVar[11]", 200);
  setTimeout("comonVar[12].className=comonVar[13]", 200);
  setTimeout("comonVar[14].className=comonVar[15]", 200);
  setTimeout("comonVar[16].className=comonVar[17]", 200);

  if(action) activeScript(action);
 }
}



function toggleOnClick(button, name, action)
{
 if(document.getElementById(name).getAttribute("active")==1)
 {
  var i=document.getElementById(name).value;
  if(i==1)
  {
   document.getElementById(button+'_a').className="togglea";
   document.getElementById(button+'_ab').className="toggleab";
   document.getElementById(button+'_b').className="toggleb";
   document.getElementById(name).value=0;
  }
  else
  {
   document.getElementById(button+'_a').className="toggleaOn";
   document.getElementById(button+'_ab').className="toggleabOn";
   document.getElementById(button+'_b').className="togglebOn";
   document.getElementById(name).value=1;
  }
  if(action) activeScript(action);
 }
}



function checkBoxOnclick(ncase, name, action)
{
 if(document.getElementById(name).getAttribute("active")==1)
 {
   var i=document.getElementById(name).value;
   if(i==1)
   {
    document.getElementById(ncase).src=""+path+"Xmind/themes/"+theme+"/check_off.png";
    document.getElementById(name).value=0;
   }
   else
   {
    document.getElementById(ncase).src=""+path+"Xmind/themes/"+theme+"/check_on.png";
    document.getElementById(name).value=1;
   }
   if(action) activeScript(action);
 }
}



function radioOnclick(nradio, name, action)
{
 var liste=document.getElementsByName('radio_'+name);
 if(liste)
 {
   var ok=1;
   for(i=0; liste[i]; i++) if(liste[i].getAttribute("active")==0) ok=0;
   if(ok)
   {
    if(liste) for(i=0; liste[i]; i++) liste[i].src=""+path+"Xmind/themes/"+theme+"/radio_off.png";
    document.getElementById(nradio).src=""+path+"Xmind/themes/"+theme+"/radio_on.png";
    document.getElementById(name).value=document.getElementById(nradio).getAttribute("realvalue");
    if(action) activeScript(action);
   }
 }
}



function spinOnClick(img, name, nbutton, min, max, step, action)
{
 if(!document.getElementById(name).readOnly)
 {
  document.getElementById(img).src=path+"Xmind/themes/"+theme+"/spinbutton"+nbutton+"_on.png";
  var i=document.getElementById(name).value;
  if(nbutton==1) i-=(-step);
  else i-=step;
  if(i<min) i=min;
  if(i>max) i=max;
  document.getElementById(name).value=i;
  comonVar[0]=document.getElementById(img);
  comonVar[1]=nbutton;
  setTimeout("comonVar[0].src=path+\'Xmind/themes/\'+theme+\'/spinbutton\'+comonVar[1]+\'.png\'", 200);
  if(action) activeScript(action);
 }
}


function ClistOnClick(row, clist, data)
{
 var frame=document.getElementById(clist).getAttribute("real");
 lastClistClicked=document.getElementById(frame).contentWindow.lastClistClicked;
 if(lastClistClicked) lastClistClicked.className="inclist";
 if(lastClistClicked!=row) row.className="inselectedclist";
 else
 {
  row='';
  data='';
 }
 document.getElementById(frame).contentWindow.lastClistClicked=row;
 document.getElementById(clist).value=data;
}


function NoteBookOnclick(nb,page)
{

 var a=document.getElementById(nb).getAttribute("last");
 if(a!=page)
 {
  document.getElementById("Xpage_"+nb+"_"+page+"a").className="pageaOn";
  document.getElementById("Xpage_"+nb+"_"+page+"ab").className="pageabOn";
  document.getElementById("Xpage_"+nb+"_"+page+"b").className="pagebOn";
  if(document.getElementById("Xpage_"+nb+"_"+page)) document.getElementById("Xpage_"+nb+"_"+page).style.display="inline";
  if(document.getElementById("Xpage_"+nb+"_"+a)) document.getElementById("Xpage_"+nb+"_"+a).style.display="none";
  document.getElementById("Xpage_"+nb+"_"+a+"a").className="pageaOff";
  document.getElementById("Xpage_"+nb+"_"+a+"ab").className="pageabOff";
  document.getElementById("Xpage_"+nb+"_"+a+"b").className="pagebOff";
  document.getElementById(nb).setAttribute("last",page);

 }
}
