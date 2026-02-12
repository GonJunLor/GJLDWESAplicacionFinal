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
        

        async function mostrarDatosUsuario(usuario) {

            main.innerHTML = `
            <div id="mostrarDatosUsuario">
                <h2>DATOS PERSONALES</h2>
                <span><button class="boton" onclick="recarga()"><span>Volver</span></button></span>
                <div class="contenido">
                    <label for="codUsuario">Usuario</label>
                    <input type="text" value="${usuario.codUsuario}" disabled>
                    <label for="descUsuario">Nombre y Apellidos</label>
                    <input type="text" value="${usuario.descUsuario}" disabled>
                    <label for="numConexiones">Número de accesos</label>
                    <input type="text" value="${usuario.numAccesos}" disabled>
                    <label for="fechaHoraUltimaConexion">Fecha de última conexion</label>
                    <input type="text" value="${usuario.getFechaFormateada()}" disabled>
                    <label for="perfil">Perfil</label>
                    <input type="text" value="${usuario.perfil}" disabled>
                </div>
            </div>
            `;

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

        function recarga() {
            location.reload();
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

                // const btnConsultar = document.createElement('button');
                // btnConsultar.innerHTML = '<span>Consultar</span>';
                // btnConsultar.addEventListener("click",() => mostrarDatosUsuario(oUsuario));
                // tdAcciones.appendChild(btnConsultar);

                const btnEliminar = document.createElement('button');
                btnEliminar.innerHTML = '<span>Eliminar</span>';
                btnEliminar.addEventListener("click",() => vistaEliminarUsuario(oUsuario));
                tdAcciones.appendChild(btnEliminar);
                
                fila.appendChild(tdAcciones);
                tbody.appendChild(fila);
            }
        }

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

    </script>
</main>
