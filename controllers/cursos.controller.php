<?php
class cursosController
{
    public function index()
    {
        // VALIDAR LAS CREDENCIALES
        $clientes = clienteModel::index("clientes");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($clientes as $key => $value) {
                if (base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) == base64_encode($value["id_cliente"] . ':' . $value["llave_secreta"])) {
                    $cursos = cursoModel::index("cursos");
                    $json = array(
                        "status" => "200",
                        "total_Resgistros" => count($cursos),
                        "detalle" => $cursos
                    );
                    echo json_encode($json, true);
                    return;
                }
            }
        }
    }

    public function create($datos)
    {

        /*=============================================
              Validar credenciales del cliente
              =============================================*/

        $clientes = clienteModel::index("clientes");

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($clientes as $key => $valueCliente) {

                if (
                    base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    base64_encode($valueCliente["id_cliente"] . ":" . $valueCliente["llave_secreta"])
                ) {
                    /*=============================================
                              Validar datos
                              =============================================*/

                    foreach ($datos as $key => $valueDatos) {
                        if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)) {

                            $json = array(

                                "status" => 404,
                                "detalle" => "Error en el campo " . $key

                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }

                    /*=============================================
                             Validar que el titulo o la descripcion no estén repetidos
                             =============================================*/

                    $cursos = cursoModel::index("cursos", "clientes", null, null);

                    foreach ($cursos as $key => $value) {

                        if ($value->titulo == $datos["titulo"]) {

                            $json = array(

                                "status" => 404,
                                "detalle" => "El título ya existe en la base de datos"

                            );

                            echo json_encode($json, true);

                            return;
                        }

                        if ($value->descripcion == $datos["descripcion"]) {

                            $json = array(

                                "status" => 404,
                                "detalle" => "La descripción ya existe en la base de datos"

                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }
                    /*=============================================
                               Llevar datos al modelo
                               =============================================*/

                    $datos = array(
                        "titulo" => $datos["titulo"],
                        "descripcion" => $datos["descripcion"],
                        "instructor" => $datos["instructor"],
                        "imagen" => $datos["imagen"],
                        "precio" => $datos["precio"],
                        "id_creador" => $valueCliente["id"],
                        "created_at" => date('Y-m-d h:i:s'),
                        "updated_at" => date('Y-m-d h:i:s')
                    );

                    $create = cursoModel::create("cursos", $datos);

                    /*=============================================
                                Respuesta del modelo
                                =============================================*/

                    if ($create == "ok") {

                        $json = array(
                            "status" => 200,
                            "detalle" => "Registro exitoso, su curso ha sido guardado"

                        );

                        echo json_encode($json, true);

                        return;

                    }
                }
            }
        }

        $json = array(

            "detalle" => "estas en la vista create"

        );

        echo json_encode($json, true);

        return;

    }

    public function show($id)
    {
        // Validar las credenciales
        $clientes = clienteModel::index("clientes");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($clientes as $key => $value) {
                if (
                    base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    base64_encode($value["id_cliente"] . ':' . $value["llave_secreta"])
                ) {

                    $curso = cursoModel::show("cursos", $id);

                    if ($curso) {
                        $json = array(
                            "status" => 200,
                            "detalle" => $curso
                        );
                    } else {
                        $json = array(
                            "status" => 404,
                            "detalle" => "No se encontró el curso solicitado"
                        );
                    }

                    echo json_encode($json, true);
                    return;
                }
            }
        }
    }

    public function update($id, $datoUpdt)
    {
        // Validar datos de cliente
        $clientes = clienteModel::index("clientes");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            foreach ($clientes as $key => $valueCliente) {
				if( "Basic ".base64_encode($_SERVER['PHP_AUTH_USER'].":".$_SERVER['PHP_AUTH_PW']) == 
					"Basic ".base64_encode($valueCliente["id_cliente"].":".$valueCliente["llave_secreta"]) ){
                    // Validaciom de datos
                    foreach ($datoUpdt as $key => $valueDatos) {
                        if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)) {

                            $json = array(

                                "status" => 404,
                                "detalle" => "Error en el campo " . $key

                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }
                    // Validar id de creador para que solo es pueda actualizar
                    $curso = cursoModel::show("cursos", $id);
                    foreach ($curso as $key => $valuecurso) {
                        if ($valuecurso->id_creador == $valueCliente["id"]) {
                            // Llevar datos verificados al modelo
                            $datoUpdt = array(
                                "id" => $id,
                                "titulo" => $datoUpdt["titulo"],
                                "descripcion" => $datoUpdt["descripcion"],
                                "instructor" => $datoUpdt["instructor"],
                                "imagen" => $datoUpdt["imagen"],
                                "precio" => $datoUpdt["precio"],
                                "updated_at" => date('Y-m-d h:i:s')
                            );

                            $update = cursoModel::update("cursos", $datoUpdt);

                            if ($update == "ok") {
                                $json = array(
                                    "status" => 200,
                                    "detalle" => "Actualizado el curso de id" . $id . ", Ahora los nuevos datoUpdt son \n" . $update
                                );
                            } else {
                                $json = array(
                                    "status" => 404,
                                    "detalle" => "No se puedo actualizar el curso"
                                );
                            }

                            echo json_encode($json, true);
                            return;
                        }
                    }
                }
            }
        }
    }
}
?>