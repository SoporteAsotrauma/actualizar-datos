function actualizarDatosComponent() {
    return {
        paciente: {},
        documento: '',
        nombre: '',
        aceptaTerminos: false,
        getInformacionPaciente() {
            // Mostrar la alerta de "buscando información"
            iziToast.show({
                title: 'Información',
                message: 'Buscando información del paciente...',
                position: 'topCenter',
                timeout: 1500, // La alerta se ocultará después de 1.5 segundos
                color: 'blue', // Color de la alerta
                icon: 'bi bi-search' // Icono que representa búsqueda
            });

            axios.get('/actualizar-datos/includes/solicitudes.php', {
                params: {
                    action: 'getInformacion',
                    documento: this.documento
                }
            }).then(response => {
                // Si la información del paciente es encontrada
                if (response.data && response.data.data) {
                    this.paciente = response.data.data;
                    this.nombre = this.paciente.nombre + ' ' + this.paciente.nombre2 + ' ' + this.paciente.apellido1 + ' ' + this.paciente.apellido2;

                    iziToast.success({
                        title: 'Éxito',
                        message: 'Información del paciente encontrada.',
                        position: 'topCenter',
                        timeout: 3000, // La alerta se ocultará después de 3 segundos
                        color: 'green', // Color verde para éxito
                        icon: 'bi bi-check-circle' // Icono de éxito
                    });
                } else {
                    // Vaciar la información del paciente y el nombre si no se encuentra
                    this.paciente = {};
                    this.nombre = '';

                    iziToast.error({
                        title: 'Error',
                        message: 'No se encontró al paciente.',
                        position: 'topCenter',
                        timeout: 3000, // La alerta se ocultará después de 3 segundos
                        color: 'red', // Color rojo para error
                        icon: 'bi bi-x-circle' // Icono de error
                    });
                }
            }).catch(error => {
                // Manejo de errores si ocurre algún fallo con la solicitud
                iziToast.error({
                    title: 'Error',
                    message: 'Hubo un problema al realizar la solicitud.',
                    position: 'topCenter',
                    timeout: 3000, // La alerta se ocultará después de 3 segundos
                    color: 'red',
                    icon: 'bi bi-x-circle'
                });
            });
        },
        actualizarDatos() {
            // Validar si las propiedades son undefined o vacías
            if (!this.paciente.telefono || !this.paciente.email || !this.paciente.direccion) {
                iziToast.warning({
                    title: 'Advertencia',
                    message: 'Por favor, completa todos los campos antes de continuar.',
                    position: 'topCenter',
                    timeout: 3000, // La alerta se ocultará después de 3 segundos
                    color: 'orange',
                    icon: 'bi bi-exclamation-triangle'
                });
                return; // Salir si alguna propiedad está vacía o es undefined
            }

            // Mostrar notificación de "actualizando datos"
            iziToast.show({
                title: 'Actualizando',
                message: 'Por favor, espera mientras se actualizan los datos...',
                position: 'topCenter',
                timeout: 1500, // La alerta se oculta automáticamente después de 1.5 segundos
                color: 'blue',
                icon: 'bi bi-cloud-upload'
            });

            // Crear el objeto FormData y enviar la solicitud
            const datos = new FormData();
            datos.append('telefono', this.paciente.telefono);
            datos.append('email', this.paciente.email);
            datos.append('direccion', this.paciente.direccion);
            datos.append('documento', this.documento);

            axios.post('/actualizar-datos/includes/solicitudes.php?action=updateInformacion', datos)
                .then(({ data }) => {
                    // Mostrar notificación de éxito
                    iziToast.success({
                        title: 'Éxito',
                        message: 'Datos actualizados correctamente.',
                        position: 'topCenter',
                        timeout: 3000, // La alerta se ocultará después de 3 segundos
                        color: 'green',
                        icon: 'bi bi-check-circle'
                    });

                    // Esperar un momento y luego recargar la página
                    setTimeout(() => {
                        window.location.reload(); // Recargar la página
                    }, 3000); // Esperar 3 segundos antes de recargar
                })
                .catch(err => {
                    // Mostrar notificación de error si falla la solicitud
                    iziToast.error({
                        title: 'Error',
                        message: 'Ocurrió un problema al actualizar los datos. Intenta nuevamente.',
                        position: 'topCenter',
                        timeout: 3000, // La alerta se ocultará después de 3 segundos
                        color: 'red',
                        icon: 'bi bi-x-circle'
                    });
                    console.error(err);
                });
        },
    }
}
