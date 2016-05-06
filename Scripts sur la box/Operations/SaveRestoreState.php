<?
// script cr�� par Pierre Pollet pour eedomus
// pour sauvegarde/restaurer des �tats
// Version 1   / 08 Novembre 2014		/ 1�re version disponible
// Version 1.1 / 17 Novembre 2014   / Ajout de la possibilit� de sauvegarder la valeur vers un autre p�riph�rique


// param�tres de configuration
$BackupPeriphId='';
$action = getArg('action');
$PeriphId=getArg('id');
$BackupPeriphId=$_GET['backup'];
$BackupOnPeriph=False;

// D�finition du noms des variables en fct de l'ID du p�riph�rique
$StateName='State'.$PeriphId;

if ($BackupPeriphId != '') $BackupOnPeriph=True;

sdk_header('text/xml');
$xmloutput="<root>";

// gestion des actions
switch(strtolower($action))
{
	case 'save':
    //Chargement des variables
    $ArrayValue=getvalue($PeriphId);
    $Value=$ArrayValue["value"];
    if  ($BackupOnPeriph)
    {
      setValue($BackupPeriphId, $Value);
    }
    else
    {
      saveVariable($StateName,$Value);
    }
    
    $xmloutput .="<action>";
    $xmloutput .="Value ".$Value." Saved";
    $xmloutput .="</action>";
    $xmloutput .="</root>";
    echo $xmloutput;
    break;
    
	case 'restore':
    if  ($BackupOnPeriph)
    {
        $ArrayValue=getvalue($BackupPeriphId);
        $Value=$ArrayValue["value"];
        setValue($PeriphId, $Value);
    }
    else
    {
        $Value=loadVariable($StateName);
        setValue($PeriphId, $Value);
    }

    $xmloutput .="<action>";
    $xmloutput .="Value ". $Value ." restored";
    $xmloutput .="</action>";  
    $xmloutput .="</root>";
    echo $xmloutput;
    break;
    
  default:
    $xmloutput .="<action>";
    $xmloutput .=strtolower($action)." is an unknown action";
    $xmloutput .="</action>";
    $xmloutput .="</root>";
    echo $xmloutput;
	  break;
}
?>