<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar datos</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
          integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="/actualizar-datos/js/app.js?v=1.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Incluye el CSS de iziToast -->
    <link href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css" rel="stylesheet">
    <!-- Incluye el JS de iziToast -->
    <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
</head>
<?php
require(__DIR__ . '/includes/header.php');
?>
<body class="bg-gray-100 flex flex-col min-h-screen">
<div
        x-data="actualizarDatosComponent()"
        style="max-width: 500px;"
        class="mx-auto overflow-auto bg-white shadow border rounded w-100 mt-4 mb-4"
>
  <span class="p-3 d-block text-center text-light bg-[#077E9D] fw-bold rounded-top">
    Actualización de datos
  </span>
        <div class="p-3 small">
            <div class="row g-0 gy-1 small mb-2 border border-1 p-2 bg-body-tertiary rounded-1">
                <span class="text-center mb-2 fw-bold"> Datos del paciente </span>
                <div id="loader-pac-info" style="display: none;"
                     class="bg-success-subtle border-start border-success p-1 shadow-sm rounded-end small mb-2 border-3">
                    Cargando Información del Paciente ...
                </div>
                <div class="p-1">
                    <label class="form-label text-muted small m-0" for="enc_doc">Documento:</label>
                    <input id="enc_doc" autofocus required="" autocomplete="enc_doc" x-model="documento"
                           x-on:change="getInformacionPaciente()" placeholder="" type="text"
                           class="form-control form-control-sm">
                    <small class="text-muted d-block" style="font-size: .67rem;">
                        Sin espacios, símbolos o letras
                    </small>
                </div>
                <div class="p-1">
                    <label class="form-label text-muted small m-0" for="enc_nombre">Nombre completo:</label>
                    <input id="enc_nombre" required="" placeholder="" x-model="nombre" type="text" disabled
                           class="form-control form-control-sm">
                </div>
                <div class="col-md-5 p-1">
                    <label class="form-label text-muted small m-0" for="enc_edad">Fecha de nacimiento:</label>
                    <div class="input-group input-group-sm">
                        <input id="enc_edad" required="" placeholder="" x-model="paciente.fech_nacim" disabled type="date"
                               class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-7 p-1">
                    <label class="form-label text-muted small m-0" for="enc_tel">Teléfono:</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"> +57 </span>
                        <input id="enc_tel" required="" placeholder="3xxxxxxxxx" pattern="3[0-9]{9}"
                               x-model="paciente.telefono" type="number" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="col-md-12 p-1">
                    <label class="form-label text-muted small m-0" for="enc_email">Correo:</label>
                    <input id="enc_email" required="" autocomplete="email" x-model="paciente.email"
                           placeholder="correo-paciente@correo.com" type="email" class="form-control form-control-sm">
                </div>
                <div class="p-1">
                    <label class="form-label text-muted small m-0" for="enc_dir">Dirc. de Residencia:</label>
                    <input id="enc_dir" required="" autocomplete="" x-model="paciente.direccion" placeholder="Ej. Calle 123"
                           type="text" class="form-control form-control-sm"
                           oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '');"
                           title="Solo se permiten letras, números y espacios." />
                    <small class="text-muted">Solo se permiten letras y números.</small>
                </div>

            </div>
        </div>
    <div class="form-check" style="margin-left: 17px; padding-bottom: 10px">
        <input class="form-check-input" type="checkbox" id="aceptoTerminos" x-model="aceptaTerminos">
        <label class="form-check-label" for="aceptoTerminos" style="font-size: 0.9rem;">
            Acepto los términos y condiciones, la política de privacidad y el tratamiento de datos personales de Clínica Asotrauma S.A.S.
        </label>
    </div>

    <div class="d-flex justify-content-between bg-[#077E9D] p-3 border-top">
            <button type="submit" :disabled="!aceptaTerminos" @click="actualizarDatos()" class="btn btn-warning btn-sm m-auto d-block">
                Actualizar datos!
            </button>
        </div>
</div>


<?php
require(__DIR__ . '/includes/footer.php');
?>
</body>
</html>
