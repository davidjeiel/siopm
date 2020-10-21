<?php

	function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the object
			$d = get_object_vars($d);
		}

		if (is_array($d)) {
			return array_map(__FUNCTION__, $d);
		} else {
			// Return array
			return $d;
		}
	}
	
	function getNumerosData($date){
		
	}

	function validarData($data) {
		$dia=substr($data,6,2);
		$mes=substr($data,4,2);
		$ano=substr($data,0,4);
		return (is_numeric($data)==1 && checkdate($mes,$dia,$ano)==1 && $ano > 1900);
	}

	function validar_nis($numero){
		
		$soma1=0;
		$soma2=0;
		$soma1=$numero[0]*3+$numero[1]*2;

		for($x=2,$y=9;$x<=9,$y>=2;$x++,$y--){
			$soma2=$soma2+$numero[$x]*$y;			
		}

		$resto=round(($soma1+$soma2)%11);
		
		if ($resto<2)
			$dv=0;
		else 
			$dv=11-$resto;

		if ($numero[10]==$dv)
			return true;
		else
			return false;
	}

	function sql_escape($value) {
		return str_replace("'", "''", $value);
	}

	// formato de entrada: "2013-08-28 13:45:00"
	function date_diff_minutes($date1, $date2) {
		$to_time = strtotime($date1);
		$from_time = strtotime($date2);
		return round(abs($to_time - $from_time) / 60,0);
	}

	//Agradecimentos ao Marcos Dimitrio por esta função
	function clean_filename($filename, $sub_char = '_') {
		return preg_replace('/[\/?*:\\\\<>\|"]/',$sub_char,$filename);
	}

	// http://stackoverflow.com/questions/689735/insert-binary-data-into-sql-server-using-php
	function prepareImageDBString($filepath) {

		$out = 'null';
		$handle = @fopen($filepath, 'rb');

		if ($handle) {
			$conteudo = @fread($handle, filesize($filepath));
			$conteudo = bin2hex($conteudo);
			@fclose($handle);
			$out = "0x".$conteudo;
		}

		return $out;
		
		// poderia ser:
		// $datastring = file_get_contents($path);
		// $data = unpack("H*hex", $datastring);
		// return "0x".$data['hex'];

	}

	function setFileToDB($sql, $server, $database, $user, $password) {
		// Fundamental para capturar arquivos grandes do banco de dados.
		ini_set('mssql.textlimit' , '2147483647'); // Valid range 0 - 2147483647. Default = 4096.
		ini_set('mssql.textsize' , '2147483647'); // Valid range 0 - 2147483647. Default = 4096.
		
		// Obter do banco
		// É obrigatório utilizar php_mssql
		
		$link = mssql_connect($server, $user, $password);

		mssql_select_db($database, $link);

		$result = mssql_query($sql);

		$row = mssql_fetch_array($result);

		$conteudo = $row[0];

		mssql_close($link); 

		return $conteudo;
		
	}
	
	function getFileFromDB($file_id, $server, $database, $user, $password) {
		// Fundamental para capturar arquivos grandes do banco de dados.
		ini_set('mssql.textlimit' , '2147483647'); // Valid range 0 - 2147483647. Default = 4096.
		ini_set('mssql.textsize' , '2147483647'); // Valid range 0 - 2147483647. Default = 4096.
		
		// Obter do banco
		// É obrigatório utilizar php_mssql
		
		$sql = "SELECT Arquivo FROM dbo.tblArquivos  WHERE ArquivoID = $file_id ";

		$link = mssql_connect($server, $user, $password);

		mssql_select_db($database, $link);

		$result = mssql_query($sql);

		$row = mssql_fetch_array($result);
		
		$conteudo = $row['Arquivo'];

		mssql_close($link); 

		return $conteudo;
	}

	function getContentType($ext_file){
		$ctype = "";
		switch ($ext_file) 
		{ 
			case "pdf": $ctype="application/pdf"; break; 
			case "exe": $ctype="application/octet-stream"; break; 
			case "7z":
			case "zip": $ctype="application/zip"; break; 
			case "docx": 
			case "doc": $ctype="application/msword"; break; 
			case "csv": 
			case "xls": 
			case "xlsx": $ctype="application/vnd.ms-excel"; break; 
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
			case "gif": $ctype="image/gif"; break; 
			case "png": $ctype="image/png"; break; 
			case "jpeg": 
			case "jpg": $ctype="image/jpg"; break; 
			case "tif": 
			case "tiff": $ctype="image/tiff"; break; 
			case "psd": $ctype="image/psd"; break; 
			case "bmp": $ctype="image/bmp"; break; 
			case "ico": $ctype="image/vnd.microsoft.icon"; break; 
			default: $ctype="application/force-download"; 
		} 

		return $ctype;
	}

	function cleanup() {

		global $zip, $file,$new_file;

		@unlink($_SESSION['file_to_process']);
		@unlink($file);
		@unlink($new_file);

		unset($_SESSION['file_to_process']);
	}

	function responseFileFromDB($arr_arquivo, $server, $database, $user, $password){

		$filename 	= $arr_arquivo['ArquivoNome'];
		$ext_file 	= $arr_arquivo['ArquivoExtensao'];
		$size 		= $arr_arquivo['ArquivoTamanho'];
		
		$ctype 		= $arr_arquivo['ArquivoMimeType'];

		//header("Pragma: public"); // required 
		header("Pragma: no-cache");
		header("Content-Type: $ctype"); 
		header("Content-Description: attachment; filename=\"$filename\""); 
		header("Content-Description: Arquivo do SIOPM");
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Length: $size"); 

		$contents 	= getFileFromDB($arr_arquivo['ArquivoID'], $server, $database, $user, $password) ;
		echo $contents;
		
	}

	function downloadFile($vo){

		$filename 	= $vo->getArquivoNome();
		$ext_file 	= $vo->getArquivoExtensao();
		$size 		= $vo->getArquivoTamanho();
		//$ctype 		= $vo->getArquivoMimeType();

		$ctype = getContentType($ext_file);
		
		ob_end_clean();

		header("Pragma: no-cache");
		header("Content-Type: \"$ctype\""); 
		header('Content-Disposition: attachment; filename="'.basename($filename).'"'); //<<< Note the " " surrounding the file name
		header("Content-Description: Arquivo do SIOPM");
		//header("Content-Transfer-Encoding: binary"); 
		header("Content-Length: $size"); 	
		header("Pragma: no-cache");

		readfile($vo->getArquivo());

	}

	function downloadExcel($arquivoNome){

		$ctype="application/vnd.ms-excel";
		header("Pragma: no-cache");
		header("Content-Type: $ctype;charset=UTF-8"); 
		header("Content-Disposition: attachment; filename=\"$arquivoNome.xls\""); //<<< Note the " " surrounding the file name
		header("Content-Description: Arquivo do SIOPM");
		header("Content-Transfer-Encoding: binary"); 
	}

	/**
 * jsonpp - Pretty print JSON data
 *
 * In versions of PHP < 5.4.x, the json_encode() function does not yet provide a
 * pretty-print option. In lieu of forgoing the feature, an additional call can
 * be made to this function, passing in JSON text, and (optionally) a string to
 * be used for indentation.
 *
 * @param string $json  The JSON data, pre-encoded
 * @param string $istr  The indentation string
 *
 * @return string
 */
function jsonpp($json, $istr='  ')
{
    $result = '';
    for($p=$q=$i=0; isset($json[$p]); $p++)
    {
        $json[$p] == '"' && ($p>0?$json[$p-1]:'') != '\\' && $q=!$q;
        if(strchr('}]', $json[$p]) && !$q && $i--)
        {
            strchr('{[', $json[$p-1]) || $result .= "\n".str_repeat($istr, $i);
        }
        $result .= $json[$p];
        if(strchr(',{[', $json[$p]) && !$q)
        {
            $i += strchr('{[', $json[$p])===FALSE?0:1;
            strchr('}]', $json[$p+1]) || $result .= "\n".str_repeat($istr, $i);
        }
    }
    return $result;
}



// Ab PHP 5.4 steht für json_encode die Konstante JSON_PRETTY_PRINT zur Verfügung.
//echo json_encode($arr, JSON_PRETTY_PRINT);

// Für PHP <= 5.3 gibt es folgende Alternative (Quelle Zend):

/**
 * Pretty-print JSON string
 *
 * Use 'format' option to select output format - currently html and txt supported, txt is default
 * Use 'indent' option to override the indentation string set in the format - by default for the 'txt' format it's a tab
 *
 * @param string $json Original JSON string
 * @param array $options Encoding options
 * @return string
 */
function json_pretty($json, $options = array())
{
    $tokens = preg_split('|([\{\}\]\[,])|', $json, -1, PREG_SPLIT_DELIM_CAPTURE);
    $result = '';
    $indent = 0;

    $format = 'txt';

    $ind = "\t";
   // $ind = "    ";

    if (isset($options['format'])) {
        $format = $options['format'];
    }

    switch ($format) {
        case 'html':
            $lineBreak = '<br />';
            $ind = '&nbsp;&nbsp;&nbsp;&nbsp;';
            break;
        default:
        case 'txt':
            $lineBreak = "\n";
            $ind = "\t";
            //$ind = "    ";
            break;
    }

    // override the defined indent setting with the supplied option
    if (isset($options['indent'])) {
        $ind = $options['indent'];
    }

    $inLiteral = false;
    foreach ($tokens as $token) {
        if ($token == '') {
            continue;
        }

        $prefix = str_repeat($ind, $indent);
        if (!$inLiteral && ($token == '{' || $token == '[')) {
            $indent++;
            if (($result != '') && ($result[(strlen($result) - 1)] == $lineBreak)) {
                $result .= $prefix;
            }
            $result .= $token . $lineBreak;
        } elseif (!$inLiteral && ($token == '}' || $token == ']')) {
            $indent--;
            $prefix = str_repeat($ind, $indent);
            $result .= $lineBreak . $prefix . $token;
        } elseif (!$inLiteral && $token == ',') {
            $result .= $token . $lineBreak;
        } else {
            $result .= ( $inLiteral ? '' : $prefix ) . $token;

            // Count # of unescaped double-quotes in token, subtract # of
            // escaped double-quotes and if the result is odd then we are 
            // inside a string literal
            if ((substr_count($token, "\"") - substr_count($token, "\\\"")) % 2 != 0) {
                $inLiteral = !$inLiteral;
            }
        }
    }
    return $result;
}

function prettyPrint( $json )
{
    $result = '';
    $level = 0;
    $in_quotes = false;
    $in_escape = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if ( $in_escape ) {
            $in_escape = false;
        } else if( $char === '"' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        } else if ( $char === '\\' ) {
            $in_escape = true;
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
    }

    return $result;
}
?>
