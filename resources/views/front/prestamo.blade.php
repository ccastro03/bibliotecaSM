@extends('layouts.mainInicio')

@section('contentInicio')
    <div class="pt-5">
        <div id="pnlProd" class="row pb-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><span id="titPnl"></span> Prestamo</h3>
                    </div>
                    <div class="card-body">
                        <div class="row w-100">
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="idLibro" class="">Libro</label>
                                <select class="form-control" name="idLibro" id="idLibro" style="width: 100% !important"></select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="idUsuario" class="">Usuario</label>
                                <select class="form-control" name="idUsuario" id="idUsuario" style="width: 100% !important"></select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group" id="fcobserva">
                                <label for="observacion" class="">Observación Devolución</label>
                                <textarea class="form-control" id="observacion" rows="5"></textarea>
                            </div>                            

                            <input name="idPrestamo" id="idPrestamo" type="text" hidden>
                            <input name="accion" id="accion" type="text" hidden>
                        </div>
                        <div class="row w-100 pt-2">
                            <button class="mb-2 mr-2 button primary ml-auto" onclick='guardar()'>Aceptar</button>
                            <button class="mb-2 mr-2 button secondary" onclick='cancelar()'>Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Listado de Prestamos</h3>

                        <div class="card-tools ml-auto">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <button class="ml-auto" onclick='nuevo()'>Nuevo</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100% !important;">                    
                            <table class="table display table-striped table-bordered" style="width: 100% !important;" id="tablaListado">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Libro</th>
                                        <th>Usuario</th>
                                        <th>Fecha Prestamo</th>
                                        <th>Fecha Devolución</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>                  
                    </div>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="mdlDetalle" tabindex="-1" role="dialog" aria-labelledby="mdlDetalle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLongTitle">Detalle del prestamo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row w-100">
                        <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                            <label class="">Libro</label>
                            <span id="splibro"></span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                            <label class="">Usuario</label>
                            <span id="spusuario"></span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                            <label class="">Fecha Prestamo</label>
                            <span id="spfecpresta"></span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                            <label class="">Fecha Devolución</label>
                            <span id="spfecdevol"></span>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-4 form-group" id="fcobserva">
                            <label class="">Observación Devolución</label>
                            <p id="spobsdevol"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $("#pnlProd").hide();

            let table = $('#tablaListado').DataTable({
                "language": {
                    "emptyTable":			"No hay datos disponibles en la tabla.",
                    "info":		   		"Del _START_ al _END_ de _TOTAL_ ",
                    "infoEmpty":			"Mostrando 0 registros de un total de 0.",
                    "infoFiltered":			"(filtrados de un total de _MAX_ registros)",
                    "infoPostFix":			"(actualizados)",
                    "lengthMenu":			"Mostrar _MENU_ registros",
                    "loadingRecords":		"Cargando...",
                    "processing":			"Procesando...",
                    "search":			"Buscar:",
                    "searchPlaceholder":		"Dato para buscar",
                    "zeroRecords":			"No se han encontrado coincidencias.",
                    "paginate": {
                        "first":			"Primera",
                        "last":				"Última",
                        "next":				"Siguiente",
                        "previous":			"Anterior"
                    },
                    "aria": {
                        "sortAscending":	"Ordenación ascendente",
                        "sortDescending":	"Ordenación descendente"
                    }
                },
                processing: true,
                serverSide: true,
                ajax: "{{ url('/prestamos/show') }}",
                columns: [
                    { data: 'id', "visible": false },
                    { data: 'libro' },
                    { data: 'usuario' },
                    { data: 'fecha_prestamo' },
                    { data: 'fecha_devolucion' },
                    { render: function (data, type, JsonResultRow, meta) {
                        var dato = "<button class='btn-ver' id='btnver' data-placement='bottom' data-html='true' title='Ver' onclick='ver()' type='button'> <i class='fas fa-eye'></i></button> &nbsp; ";
                        if(JsonResultRow['observacion'] == null){
                            dato += "<button class='btn-devolver' id='btnreturn' data-placement='bottom' data-html='true' title='Devolver' onclick='devolver()' type='button'> <i class='fas fa-undo-alt'></i></button>";
                        };
                        return dato;
                        }
                    }
                ],
                "order": [[1, 'desc']]
            });

            $('#tablaListado tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('#idLibro').select2({
                ajax: {
                    url: '/listLibros',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            busqueda: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Seleccione ...',
                language: {
                    noResults: function() {
                        return "No hay resultados";        
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }         
            });

            $('#idUsuario').select2({
                ajax: {
                    url: '/listUsuarios',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            busqueda: params.term,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Seleccione ...',
                language: {
                    noResults: function() {
                        return "No hay resultados";        
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }         
            });            
        });

        function nuevo(){
            limpiarCampos();
            $('#fcobserva').addClass("d-none");
            $("#pnlProd").fadeIn(900);
            $("#accion").val('1');
            $("#idLibro").focus();
        };

        function cancelar(){
            limpiarCampos();
            $("#pnlProd").fadeOut(300);
        };

        function limpiarCampos(){
            $("#idLibro").val('').trigger('change');
            $("#idUsuario").val('').trigger('change');
            $("#observacion").val('');
            $("#idPrestamo").val('');
        };

        function guardar(){
            var idLibro = document.getElementById("idLibro").value;
            var idUsuario = document.getElementById("idUsuario").value;
            var observacion = document.getElementById("observacion").value;

            var idPrestamo = document.getElementById("idPrestamo").value;
            var tipoAcc = document.getElementById("accion").value;        
            var msg = '';          

            if(idLibro == ''){
                $('#idLibro').addClass("is-invalid");
                msg += '<em>El campo libro debe estar lleno</em><br>';
            }else{
                $('#idLibro').removeClass("is-invalid");
            }

            if(idUsuario == ''){
                $('#idUsuario').addClass("is-invalid");
                msg += '<em>El campo usuario debe estar lleno</em><br>';
            }else{
                $('#idUsuario').removeClass("is-invalid");
            }

            if(tipoAcc == '2'){
                if(observacion == ''){
                    $('#observacion').addClass("is-invalid");
                    msg += '<em>El campo observacion debe estar lleno</em><br>';
                }else{
                    $('#observacion').removeClass("is-invalid");
                }                
            }

            if(msg == ''){
                if(tipoAcc == '1'){ // 1 - significa que esta insertando
                    $.ajax({
                        url: "/prestamos",
                        type: 'POST',
                        data: {'idLibro':idLibro,'idUsuario':idUsuario},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        error: function(err) {
                            alertasCustom(4,'¡Error!',err.statusText+" : "+err.responseJSON['message']); // 1: success, 2:info, 3:warning, 4:error
                        },
                        success: function(res) {
                            alertasCustom(1,'¡Exito!',res); // 1: success, 2:info, 3:warning, 4:error
                            $("#pnlProd").fadeOut(300);
                            $('#tablaListado').DataTable().ajax.reload();
                            limpiarCampos();
                            return false;
                        }
                    });
                }

                if(tipoAcc == '2'){ // 2 significa que esta actualizando
                    $.ajax({
                        url: "/prestamos/"+idPrestamo,
                        type: 'PUT',
                        data: {'observacion':observacion},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        error: function(err) {
                            alertasCustom(4,'¡Error!',err.statusText+" : "+err.responseJSON['message']); // 1: success, 2:info, 3:warning, 4:error
                        },
                        success: function(res) {
                            alertasCustom(1,'¡Exito!',res); // 1: success, 2:info, 3:warning, 4:error
                            $("#pnlProd").fadeOut(300);
                            $('#tablaListado').DataTable().ajax.reload();
                            limpiarCampos();
                            return false;
                        }
                    });
                }            
            }else{
                alertasCustom(4,'¡Atencion!',msg); // 1: success, 2:info, 3:warning, 4:error
            }
        };

        function devolver(){
            var table = $('#tablaListado').DataTable();
            $('#tablaListado tbody').on( 'click', 'tr', function (e) {

                if(e.target.className == 'fas fa-undo-alt' || e.target.className == 'btn-devolver'){
                    var idx = table.row(this).index();
                    var arrData = table.row(idx).data();

                    if( arrData['observacion'] == null ){
                        $('#idLibro').empty().append($("<option/>").val(arrData['id_libro']).text(arrData['libro'])).val(arrData['id_libro']).trigger("change");
                        $('#idUsuario').empty().append($("<option/>").val(arrData['id_usuario']).text(arrData['usuario'])).val(arrData['id_usuario']).trigger("change");

                        $('#fcobserva').removeClass("d-none");

                        $("#idPrestamo").val(arrData['id']);
                        $("#accion").val('2');

                        $("#pnlProd").fadeIn(900);
                        $("#idLibro").focus();
                    }
                }
            });
        };

        function ver(){
            var table = $('#tablaListado').DataTable();
            $('#tablaListado tbody').on( 'click', 'tr', function (e) {
                if(e.target.className == 'fas fa-eye' || e.target.className == 'btn-ver'){
                    var idx = table.row(this).index();
                    var arrData = table.row(idx).data();

                    document.getElementById('splibro').innerHTML = arrData['libro'];
                    document.getElementById('spusuario').innerHTML = arrData['usuario'];
                    document.getElementById('spfecpresta').innerHTML = arrData['fecha_prestamo'];
                    document.getElementById('spfecdevol').innerHTML = arrData['fecha_devolucion'];
                    document.getElementById('spobsdevol').innerHTML = arrData['observacion'];

                    $("#mdlDetalle").modal("show");
                }
            });
        };        
    </script>    
@endsection