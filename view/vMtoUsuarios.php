<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 05/02/2026
*/
?>
<main id="vMtoUsuarios">
    <form action="" method="post">
        <div>
            <button name="volver" class="boton"><span>Volver</span></button> 
        </div>
    </form>
    <div class="columna1">
        <div class="tarjeta">
            <div><h2>Buscar usuario</h2></div>
            <div>
                <span>
                    <label for="DescUsuarioBuscado">Introduce Usuario a Buscar: </label>
                    <input type="text" name="DescUsuarioBuscado" id="DescUsuarioBuscado" value="">
                </span>  
            </div>
        </div>
        <div class="tarjeta">
            <div><h2>Resultado</h2></div>
            <div>
                <table id="tablaResultado">
                    <tr>
                    <th>Código</th>
                    <th>Departamento▼</th>
                    <th>Fecha de Creacion</th>
                    <th>Volumen de Negocio</th>
                    <th>Fecha de Baja</th>
                    </tr>
                </table>
                <?php 

                    // foreach ($avMtoDepartamentos as $aDepartamento){
                    //     <tr>
                    //     <td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['codDepartamento'] . '</td>
                    //     <td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['descDepartamento'] . '</td>
                    //     <td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['fechaCreacionDepartamento'] . '</td>
                    //     <td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['volumenDeNegocio'] . '</td>
                    //     <td class="'.$aDepartamento['estadoDepartamento'].'">' . $aDepartamento['fechaBajaDepartamento'] . '</td>
                    //     <td><button name="editar" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="editar"><span>Editar</span></button></td>
                    //     <td><button name="mostrar" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="mostrar"><span>Mostrar</span></button></td>
                    //     <td><button name="borrar" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="borrar"><span>Borrar</span></button></td>
                    //     <td><button name="bajaAlta" value="'.$aDepartamento['codDepartamento'].'" class="boton" id="bajaAlta"><span>'.$aDepartamento['estadoDepartamento'].'</span></button></td>
                    //     </tr>
                    // }

                ?>
                
            </div>
        </div>
    </div>
    <script>
        var cuadroBusqueda = document.getElementById('DescUsuarioBuscado');
        var tabla = document.getElementById('tablaResultado');
        var aUsuarios;

        cuadroBusqueda.addEventListener("input", async (e)=>{
            e.preventDefault();
            const aUsuarios = await pedirUsuarios(cuadroBusqueda.value);
            tabla.innerHTML =`
                <table id="tablaResultado">
                    <tr>
                    <th>Código</th>
                    <th>Usuario</th>
                    <th>Fecha de Creacion</th>
                    <th>Volumen de Negocio</th>
                    <th>Fecha de Baja</th>
                    </tr>
                </table>
            `;
            for (const usuario of aUsuarios) {
                tabla.innerHTML += `
                    <tr>
                    <td>${usuario.codUsuario}</td>
                    <td>${usuario.descUsuario}</td>
                    <td>${usuario.fechaHoraUltimaConexion}</td>
                    <td>${usuario.codUsuario}</td>
                    <td>${usuario.codUsuario}</td>
                `;
            }
        })
        


        async function pedirUsuarios(descUsuario) { // Ahora es async
            
            // 1. Creamos el controlador y el temporizador
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 segundos

            try {
                const respuesta = await fetch("http://daw205.local.ieslossauces.es/GJLDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php?descUsuario=" + descUsuario, {
                    signal: controller.signal // 2. Pasamos la señal al fetch
                });

                // Si llega aquí, la respuesta fue exitosa antes de los 5s
                clearTimeout(timeoutId); // Limpiamos el timer

                const datos = await respuesta.json();
                return datos;

            } catch (error) {
                // 3. Manejamos el caso específico del timeout o cualquier otro error
                if (error.name === 'AbortError') {
                    console.warn("La API tardó demasiado (5s). Usando palabra por defecto.");
                } else {
                    console.error("Error de red o servidor:", error);
                }
                
                return null;
            }
        }

    </script>
</main>
