<?php
 /**********************************************************************
  * 
  * For mor info look at the *.txt files
  *	
  * functions.php - some functions to make things look prettier
  * 
  **********************************************************************/

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


/**
 * Establishes a database connection.
 *
 * @param string $dbserver
 * @param string $dbuser
 * @param string $dbpassword
 * @param string $dbname
 */



function DoConnect() 
{
	global $dbhost, $dbuser, $dbpassword, $dbname;
	
	$success = mysql_connect($dbhost, $dbuser, $dbpassword);
	if (!$success)
		sqldie("$success");
		mysql_set_charset('utf8', $success); 
		$success = mysql_selectdb ($dbname);
	
	if (!$success) {
		sqldie($success);
	}
}
				

/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


/**
 * The Query function
 *
 * @param string $message
 *
 * @todo: make this prettier
 */

function query($quer)
{
  $result = mysql_query($quer);

  if (mysql_error())
    dienice("<b>Message:</b> " . mysql_error() . "<br /><b>Query:</b> $quer");

  return $result;
}


/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


 /**
 * Dies with a cleaner look than a standard die.
 *
 * @param string $message
 *
 * @todo: make this prettier
 */
function dienice($message)
{
	
	echo " <font color='#FF0000'><b>An error has occured and the script simply can't go on...</b><br></font>" . $message;
	die();
}



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/



 /**
 * Calls dienice with mysql_error appended to $message.
 *
 * @param string $message
 *
 * @todo: make this prettier
 */
function sqldie($message)
{
	dienice($message . " " . mysql_error());
}



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


 /**
 * Makes the end time
 *
 */
function theend()
{
	global $start_time;
	 $query_time = explode(' ',microtime());
	 $total_time = ($query_time[1].substr($query_time[0],1)) - $start_time;
	 echo ''.substr($total_time,0,8),' seconds';
}




function xmlToArray($xml, $options = array()) {
    $defaults = array(
        'namespaceSeparator' => ':',//you may want this to be something other than a colon
        'attributePrefix' => '@',   //to distinguish between attributes and nodes with the same name
        'alwaysArray' => array(),   //array of xml tag names which should always become arrays
        'autoArray' => true,        //only create arrays for tags which appear more than once
        'textContent' => '$',       //key used for the text content of elements
        'autoText' => true,         //skip textContent key if node has no attributes or child nodes
        'keySearch' => false,       //optional search and replace on tag and attribute names
        'keyReplace' => false       //replace values for above search values (as passed to str_replace())
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; //add base (empty) namespace
 
    //get attributes from all namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            //replace characters in attribute name
            if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }
 
    //get child nodes from all namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->children($namespace) as $childXml) {
            //recurse into child nodes
            $childArray = xmlToArray($childXml, $options);
            list($childTagName, $childProperties) = each($childArray);
 
            //replace characters in tag name
            if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            //add namespace prefix, if any
            if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
 
            if (!isset($tagsArray[$childTagName])) {
                //only entry with this key
                //test if tags of this type should always be arrays, no matter the element count
                $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (
                is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                //key already exists and is integer indexed array
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                //key exists so convert to integer indexed array with previous value in position 0
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
        }
    }
 
    //get text content of node
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
 
    //stick it all together
    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
 
    //return node as array
    return array(
        $xml->getName() => $propertiesArray
    );
}