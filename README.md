# Cifrado_Descrifrado_XOR_PHP
Este código en PHP resuelve el nivel de "Natas 11" de la pagina "Over The Wire" de retos de ciberseguridad.

EL código obtiene la "key" o clave del cifrado XOR usado para cifrar la cookie de la página. Con ayuda de esa clave podemos descifrar la cookie, pero en este caso la utilizaremos para cifrar nuestra propia cookie, en la que utilizaremos para establecerla en la página y obtener la contraseña del siguiente nivel "natas 12".

EL código tambien contiene peticiones GET a los Endpoints de cada usuario tanto a natas11 y 12, peticiones en donde se establecen las cookies, tanto para obtener el pass de natas 12 y logearnos en su página.
