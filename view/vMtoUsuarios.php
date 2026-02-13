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
                <span id="mensajesGenerales"></span> 
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
                this.contrasenaNueva = "";
                this.repiteContrasena = "";
                this.errorContrasenaNueva = "";
                this.errorRepiteContrasena = "";
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

            setContrasenaNueva(mensaje){
                this.errorContrasenaNueva = mensaje;
            }
            setRepiteContrasena(mensaje){
                this.errorRepiteContrasena = mensaje;
            }

            setErrorContrasenaNueva(mensaje){
                this.errorContrasenaNueva = mensaje;
            }
            setErrorRepiteContrasena(mensaje){
                this.errorRepiteContrasena = mensaje;
            }

        }
        var cuadroBusqueda = document.getElementById('DescUsuarioBuscado');
        var tbody = document.getElementById('tablaResultado');
        var main = document.getElementById('vMtoUsuarios');
        const API_KEY_NUESTRA = 'XZuVZLROAF6FyluURwSTaJOLesWQZYrFZ9JX7E8n';
        var servidor = "https://gonzalojunlor.ieslossauces.es/GJLDWESAplicacionFinal";
        var servidor = "https://192.168.1.205/GJLDWESAplicacionFinal";

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
            document.getElementById("mensajesGenerales").value = "";

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
                btnPassword.addEventListener("click",() => vistaCambiarPasswordUsuario(oUsuario));
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

        async function vistaCambiarPasswordUsuario(usuario) {
            let divBuscarTabla = document.getElementsByClassName("columna1")[0];
            divBuscarTabla.classList.add("inhabilitar");
            main.innerHTML += `
            <div class="columna1 columnaPassword">
            <div>
                <div class="tarjeta" id="tarjetaPasswordUsuario">
                    <div><h2>Cambiar contraseña de <strong class="rojo">${usuario.descUsuario}</strong></h2></div>
                    <div>
                        <label for="contrasenaNueva">Nueva contraseña</label>
                        <input type="password" class="obligatorio" id="contrasenaNueva" name="contrasenaNueva">
                        <span class="error rojo" id="errorContrasenaNueva"></span>
                        <label for="repiteContrasena">Repite contraseña</label>
                        <input type="password" class="obligatorio" id="repiteContrasena" name="repiteContrasena">
                        <span class="error rojo" id="errorRepiteContrasena"></span>
                        <button onclick="cambiarPasswordUsuario('${usuario.codUsuario}')"><span>GUARDAR</span></button>
                        <button id="cancelarEliminar" onclick="recarga()"><span>CANCELAR</span></button>  
                    </div>
                </div>
            </div>
            </div>
            `;

            // Eventos para que al darle enter desde uno de los dos inputs sea como si le ha dado a guardar
            document.getElementById("contrasenaNueva").addEventListener("keydown", (e) =>{
                if (event.key === "Enter") {
                    // event.preventDefault();
                    cambiarPasswordUsuario(usuario.codUsuario);
                }
            });
            document.getElementById("repiteContrasena").addEventListener("keydown", (e) => {
                if (event.key === "Enter") {
                    // event.preventDefault();
                    cambiarPasswordUsuario(usuario.codUsuario);
                }
            });
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

        async function cambiarPasswordUsuario(codUsuario) {
            let cuadroContrasenaNueva = document.getElementById("contrasenaNueva");
            let cuadroRepiteContrasena = document.getElementById("repiteContrasena");
            let spanErrorContrasenaNueva = document.getElementById("errorContrasenaNueva");
            let spanErrorRepiteContrasena = document.getElementById("errorRepiteContrasena");

            try {  
                const respuesta = await fetch(
                    servidor + "/api/wsCambiarPasswordUsuario.php"+
                    "?api_key="+API_KEY_NUESTRA+"&codUsuario=" + codUsuario +
                    "&contrasenaNueva=" + encodeURIComponent(cuadroContrasenaNueva.value) +
                    "&repiteContrasena=" + encodeURIComponent(cuadroRepiteContrasena.value)
                );
                /* encodeURIComponent() sirve para que se envie bien la contraseña si hay simbolos como +
                ya que sino se envia un espacio y hace que se guarde mal en la bbdd */

                datosJSON = await respuesta.json();
                
                if(datosJSON.estadoCambioPassword===true){
                    location.reload();
                }else{
                    spanErrorContrasenaNueva.innerHTML = datosJSON.ErrorContrasenaNueva;
                    spanErrorRepiteContrasena.innerHTML = datosJSON.ErrorRepiteContrasena;
                }
   
            } catch (error) {
                spanErrorContrasenaNueva.innerHTML = "Error de conexion con la api"
            }        
        }
        
        /* OTRAS FUNCIONES */

    </script>
</main>
