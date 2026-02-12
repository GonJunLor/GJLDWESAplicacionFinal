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
            <div></div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Usuario▼</th>
                            <th>Accesos</th>
                            <th>Fecha última conexión</th>
                            <th>Perfil</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tablaResultado"></tbody>
                </table>                
            </div>
        </div>
    </div>
    <script>
        class Usuario {
            constructor(datos) {
                this.codUsuario = datos.codUsuario;
                this.descUsuario = datos.descUsuario;
                this.numAccesos = datos.numAccesos;
                this.fechaHoraUltimaConexion = datos.fechaHoraUltimaConexion;
                this.perfil = datos.perfil;
            }

            getFechaFormateada(){
                // let fechaFormateada = '- -';
                if (this.fechaHoraUltimaConexion!==null) {
                    let fecha = new Date(this.fechaHoraUltimaConexion);
                    // clase para formatear fechas segun el idioma
                    return new Intl.DateTimeFormat('es-ES').format(fecha);
                }
                return "";
            }
        }
        var cuadroBusqueda = document.getElementById('DescUsuarioBuscado');
        var tbody = document.getElementById('tablaResultado');
        var main = document.getElementById('vMtoUsuarios');
        const API_KEY_NUESTRA = 'XZuVZLROAF6FyluURwSTaJOLesWQZYrFZ9JX7E8n';
        var servidor = "https://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal";

        // Función para inicializar la carga al entrar en la página
        async function inicio() {
            // Intentamos recuperar el valor guardado y de existir lo ponemos en el cuadro de busqueda 
            cuadroBusqueda.value = sessionStorage.getItem('buscarDescUsuarioActual')!== null?sessionStorage.getItem('buscarDescUsuarioActual'):'';

            mostrarUsuarios(await pedirUsuarios(cuadroBusqueda.value));
        }
        // Llamamos a la función de inicio
        inicio();

        cuadroBusqueda.addEventListener("input", async (e)=>{
            // Guardamos el valor en el almacenamiento local
            sessionStorage.setItem('buscarDescUsuarioActual', cuadroBusqueda.value);

            mostrarUsuarios(await pedirUsuarios(cuadroBusqueda.value));
        })
        
        function recarga() {
            location.reload();
        }

        /* VISTAS */
        function mostrarUsuarios(aUsuarios) {
            tbody.innerHTML = '';
            
            for (const usuario of aUsuarios) {
                // Creamos la instancia del objeto
                const oUsuario = new Usuario(usuario);

                fila = document.createElement('tr');

                // funcion para no repetir mucho el código
                function crearCelda(texto) {
                    let td = document.createElement('td');
                    td.textContent = texto;
                    fila.appendChild(td);
                }

                // Añadimos las celdas de datos en una línea cada una
                crearCelda(oUsuario.codUsuario);
                crearCelda(oUsuario.descUsuario);
                crearCelda(oUsuario.numAccesos);
                crearCelda(oUsuario.getFechaFormateada());
                crearCelda(oUsuario.perfil);

                // Celda de acciones (Botones)
                const tdAcciones = document.createElement('td');

                const btnEliminar = document.createElement('button');
                btnEliminar.innerHTML = '<span>Eliminar</span>';
                btnEliminar.addEventListener("click",() => vistaEliminarUsuario(oUsuario));
                tdAcciones.appendChild(btnEliminar);

                const btnPassword = document.createElement('button');
                btnPassword.innerHTML = '<span>Password</span>';
                btnPassword.addEventListener("click",() => cambiarPasswordUsuario(oUsuario));
                tdAcciones.appendChild(btnPassword);
                
                fila.appendChild(tdAcciones);
                tbody.appendChild(fila);
            }
        }

        function vistaEliminarUsuario(usuario) {
            let divBuscarTabla = document.getElementsByClassName("columna1")[0];
            divBuscarTabla.classList.add("inhabilitar");
            main.innerHTML += `
                <div class="columna1 columnaEliminar">
                <div>
                    <div class="tarjeta" id="tarjetaEliminarUsuario">
                        <div><h2>¿Estás seguro de que quieres eliminar el usuario <strong class="rojo">${usuario.descUsuario}</strong>?</h2></div>
                        <div>
                            <button onclick="eliminarUsuario('${usuario.codUsuario}')"><span>ACEPTAR</span></button>
                            <button id="cancelarEliminar" onclick="recarga()"><span>CANCELAR</span></button>     
                        </div>
                    </div>
                </div>
                </div>
            `;
        }

        async function cambiarPasswordUsuario(usuario) {
            let divBuscarTabla = document.getElementsByClassName("columna1")[0];
            divBuscarTabla.classList.add("inhabilitar");
            main.innerHTML += `
            <div id="cambiarPasswordUsuario">
                <h2>Cambiar Contraseña</h2>
                <form class="contenido" action="" method="post"> 
                    <label for="contrasenaActual">Contraseña actual</label>
                    <input type="text" class="obligatorio" id="contrasenaActual" name="contrasenaActual" value="<?php echo $_REQUEST['contrasenaActual']??''; ?>">
                    <span class="error rojo"><?php echo $aErrores['contrasenaActual'] ?></span>
                    <label for="contrasenaNueva">Nueva contraseña</label>
                    <input type="password" class="obligatorio" id="contrasenaNueva" name="contrasenaNueva" value="<?php echo $_REQUEST['contrasenaNueva']??''; ?>">
                    <span class="error rojo"><?php echo $aErrores['contrasenaNueva'] ?></span>
                    <label for="repiteContrasena">Repite contraseña</label>
                    <input type="password" class="obligatorio" id="repiteContrasena" name="repiteContrasena" value="<?php echo $_REQUEST['repiteContrasena']??''; ?>">
                    <span class="error rojo"><?php echo $aErrores['repiteContrasena'] ?></span>
                    <button name="guardar" class="boton" id="guardar"><span>GUARDAR</span></button>
                    <button name="cancelar" class="boton" id="cancelar"><span>Cancelar</span></button>
                </form>
            </div>
            `;

        }

        /* LLAMADAS A APIS */
        async function pedirUsuarios(descUsuario) {
            try {
                const respuesta = await fetch(
                    servidor + "/api/wsBuscaUsuariosPorDescripcion.php"+
                    "?api_key=" + API_KEY_NUESTRA + "&descUsuario=" + descUsuario
                );
                return await respuesta.json();
            } catch (error) {                
                return null;
            }
        }

        async function eliminarUsuario(codUsuario) {
            try {
                const respuesta = await fetch(
                    servidor + "/api/wsEliminaUsuarioPorCodUsuario.php"+
                    "?api_key="+API_KEY_NUESTRA+"&codUsuario=" + codUsuario
                );

                datosJSON = await respuesta.json();
                if(datosJSON.estadoEliminarUsuario===true){
                    location.reload();
                }else{
                    document.getElementById('tarjetaEliminarUsuario').innerHTML += "<p>Error al eliminar usuario</p>";
                }
   
            } catch (error) { 
                document.getElementById('tarjetaEliminarUsuario').innerHTML += "<p>Error al eliminar usuario</p>";
            }         
        }
        
    </script>
</main>
