<?php
/** ----------------------------------------------------------------------------
 *   Descripcion    : Clases Conexion de PosgreSQL
 *     Manejador  	: PorsgreSQL - Charset: UTF-8
 *        Author    : Anibal G. Tillero O.
 *  Date created    : 11/08/2009            Date updated: 15/10/2009
 *       Docs By    : Anibal G. Tillero O.
 *     Copyright    : (c) 2009 by MPPRE.
 * -----------------------------------------------------------------------------
 */

class pgsql {
	private $linkid; 	// PostgreSQL link identificado
	private $db_host; 	// PostgreSQL servidor host
	private $db_usuario;	// PostgreSQL usuario
	private $db_clave; 	// PostgreSQL clave
	private $db_nombre; 	// PostgreSQL database
	private $db_puerto;	// Puerto del Postgres
	private $resultado; 	// Resulatdos del Query
	private $querycount; 	// Total queries executados


/*
 * Classe constructor.server: 10.11.11.22
usuario: legal
clave: LEG@l
 *
 * Descripcion: Inicialzar el $host, $Usuario, $clave y campos de $db.
 */
 // S E R V I D O R   PRODUCCION
//function __construct($db_host = '10.11.11.9', $db_nombre = 'legalizacionescitas', $db_usuario = 'vacaciones' , $db_clave = 'v4c4c10n3s' ,  $db_puerto = '5432') {
//function __construct($db_host = '10.11.11.57', $db_nombre = 'legalizacionescitas', $db_usuario = 'legalizacionescitas' , $db_clave = '#!#legalizacionescitas#*!#/#' ,  $db_puerto = '5432') {
//function __construct($db_host = '10.11.11.40', $db_nombre = 'legalizacionescitas', $db_usuario = 'legalizacionescitas' , $db_clave = '#legalizacionescitas@' ,  $db_puerto = '5432') {    
//function __construct($db_host = '172.27.3.103', $db_nombre = 'legalizacionescitas', $db_usuario = 'postgres' , $db_clave = '#!#legalizacionescitas#*!#/#' ,  $db_puerto = '5432') {
// S E R V I D O R   TESTING
/*function __construct($db_host = '10.11.11.54', $db_nombre = 'legalizacionesw', $db_usuario = 'legalizaciones' , $db_clave = 'legalizaciones' ,  $db_puerto = '5432') {*/
//function __construct($db_host = '10.11.11.40', $db_nombre = 'legalizacionescitas', $db_usuario = 'legalizacionescitas' , $db_clave = '#legalizacionescitas@' ,  $db_puerto = '5432') {    
//function __construct($db_host = '127.0.0.1', $db_nombre = 'legalizacionescitas', $db_usuario = 'postgres' , $db_clave = 'xorre1310' ,  $db_puerto = '5432') {    
//function __construct($db_host = '10.11.11.40', $db_nombre = 'legalizacionescitas', $db_usuario = 'sistemas' , $db_clave = 'sistemas' ,  $db_puerto = '5432') {            
function __construct($db_host = '10.11.11.40', $db_nombre = 'legalizacionescitas', $db_usuario = 'postgres' , $db_clave = 'postgres' ,  $db_puerto = '5432') {            

	$this->db_host = $db_host;
	$this->db_usuario = $db_usuario;
	$this->db_clave = $db_clave;
	$this->db_nombre = $db_nombre;
	$this->db_puerto = $db_puerto;

try  {
    $this->linkid= @pg_connect('host='.$this->db_host.' user='.$this->db_usuario.' password='.$this->db_clave.' dbname='.$this->db_nombre.' port='.$this->db_puerto ) ;
    if (!(@pg_connection_status( $this->linkid ) == "PG_CONNECTION_BAD")) {
       	throw new Exception("No existe conexión con el servidor de PostgreSQL. " . @pg_last_error($this->linkid)   );
    }

 } catch (Exception $e) {   die($e->getMessage());  }



}



/* Execute database query. */
public function setQuery($Query){
	try
	{
		$this->resultado = @pg_query($this->linkid,$Query);
		if($this->resultado === FALSE)
			throw new Exception('');
	} catch (Exception $e){
		echo $e->getMessage();
	}
	$this->querycount++;
	return $this->resultado;
}




/*
 * Descripcion: Retorna el resultado del Query como un objeto.  en vez de un array.
 *              Indirectamente, eso significa que solo puedes acceder a los datos por medio de su nombre de campo, y no a trav�s de sus posiciones
 *              (los números son nombres de propiedad invalidos)
 */
public function getFetch_Object() {
	$row = @pg_fetch_object($this->resultado);
	return $row;
}


/*
 * Descripcion: Retorna el resultado del Query como un Arreglo.
 *
 *              Es una versión extendida de pg_fech_row().
 * 			    Además de almacenar los datos en los índices numericos del array resultante,
 *			    también almacena los datos usando índices asociativos, empleando para ello el nombre del campo como la llave o �ndice.
 */
public function getFetch_Array(){
	$row = @pg_fetch_array($this->resultado);
	return $row;
}


/*
 * Descripcion: Retorna el resultado del Query como un Arreglo.
 *
 *              Es una versión extendida de pg_fech_row().
 * 			    Además de almacenar los datos en los índices numericos del array resultante,
 */
public function getFetch_row() {
    $row = @pg_fetch_row( $this->resultado );
	return $row;
}


/*
 * Descripcion: Retorna el resultado del Query como un Arreglo.
 *
 *              Es una versión extendida de pg_fech_row().
 * 			    Además de almacenar los datos en los índices numericos del array resultante,
 */

public function getFetch_row_OID() {
    $row = @pg_fetch_row( $this->resultado );
    $OID = $row[0] ;

	return $OID;
}


/*
 * Descripcion: Retorna el resultado del Query como un Arreglo.
 *
 * 		    también almacena los datos usando índices asociativos, empleando para ello el nombre del campo como la llave o índice.
 */
public function getFetch_assoc() {
    $row = @pg_fetch_assoc( $this->resultado );
	return $row;
}


/*
 *  Descripcion: Determina el total de filas afectadas por el Query
 *                returns the number of tuples (instances/records/rows) affected by INSERT, UPDATE, and DELETE queries.
*/
public function getAffectedRows(){
	$rec_affected = @pg_affected_rows( $this->resultado );
    return $rec_affected;
}


/* Determine total rows returned by query */
public function getNumRows(){
	$count = @pg_num_rows( $this->resultado );
	return $count;
}


/* Return total number of queries executed during
lifetime of this object. Not required, but
interesting nonetheless. */
function numQueries(){
	return $this->querycount;
}


public function setClose($bClose = true) {

	@pg_query("COMMIT");
	@pg_free_result($this->resultado);			// Libera la memoria utilizada
	if ($bClose)
	@pg_close($this->linkid);
}


}
?>
