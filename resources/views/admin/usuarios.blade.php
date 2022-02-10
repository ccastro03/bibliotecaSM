@extends('layouts.mainInicio')

@section('contentInicio')
    <div class="pt-5">
        <div id="pnlProd" class="row pb-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><span id="titPnl"></span> Usuario</h3>
                    </div>
                    <div class="card-body">
                        <div class="row w-100">
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="nombre" class="">Nombre</label>
                                <input name="nombre" id="nombre" type="text" class="form-control" >
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="identificacion">identificación</label>
                                <input name="identificacion" id="identificacion" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="telefono">Teléfono</label>
                                <input name="telefono" id="telefono" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="email">Email</label>
                                <input name="email" id="email" type="text" class="form-control">
                            </div>

                            <input name="idusuario" id="idusuario" type="text"  hidden>
                            <input name="accion" id="accion" type="text"  hidden>
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
                        <h3 class="card-title">Listado de Usuarios</h3>

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
                                        <th>Nombre</th>
                                        <th>Identificación</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
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
                ajax: "{{ url('/usuarios/show') }}",
                columns: [
                    { data: 'id', visible:false },
                    { data: 'nombre' },                    
                    { data: 'identificacion' },
                    { data: 'telefono' },
                    { data: 'email' },
                    { defaultContent: "<button id='btnedit' data-placement='bottom' data-html='true' title='Modificar' onclick='editar()' type='button'>"+
                        "<i class='fas fa-pencil-alt'></i></button> &nbsp; "+
                        "<button data-placement='bottom' data-html='true' title='Eliminar' onclick='eliminar()' type='button'>"+
                        "<i class='fas fa-trash'></i></button>"}
                ],
                "order": [[1, 'asc']]          
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
        });

        function nuevo(){
            limpiarCampos();
            $("#pnlProd").fadeIn(900);
            $("#accion").val('1');
            $("#nombre").focus();
        };

        function cancelar(){
            limpiarCampos();
            $("#pnlProd").fadeOut(300);
        };

        function limpiarCampos(){
            $("#nombre").val('');
            $("#identificacion").val('');
            $("#telefono").val('');
            $("#email").val('');
        };

        function guardar(){
            var nombre = document.getElementById("nombre").value;
            var identificacion = document.getElementById("identificacion").value;
            var telefono = document.getElementById("telefono").value;
            var email = document.getElementById("email").value;

            var idusuario = document.getElementById("idusuario").value;
            var tipoAcc = document.getElementById("accion").value;        
            var msg = '';          

            if(nombre == ''){
                $('#nombre').addClass("is-invalid");
                msg += '<em>El campo nombre debe estar lleno</em><br>';
            }else{
                $('#nombre').removeClass("is-invalid");
            }

            if(identificacion == ''){
                $('#identificacion').addClass("is-invalid");
                msg += '<em>El campo identificación debe estar lleno</em><br>';
            }else{
                $('#identificacion').removeClass("is-invalid");
            }

            if(telefono == ''){
                $('#telefono').addClass("is-invalid");
                msg += '<em>El campo telefono debe estar lleno</em><br>';
            }else{
                $('#telefono').removeClass("is-invalid");
            }

            if(email == ''){
                $('#email').addClass("is-invalid");
                msg += '<em>El campo email debe estar lleno</em><br>';
            }else{
                $('#email').removeClass("is-invalid");
            }

            if(msg == ''){
                if(tipoAcc == '1'){ // 1 - significa que esta insertando
                    $.ajax({
                        url: "/usuarios",
                        type: 'POST',
                        data: {'nombre':nombre,'identificacion':identificacion,'telefono':telefono,'email':email},
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
                        url: "/usuarios/"+idusuario,
                        type: 'PUT',
                        data: {'nombre':nombre,'identificacion':identificacion,'telefono':telefono,'email':email},
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

        function eliminar(){
            var table = $('#tablaListado').DataTable();
            $('#tablaListado tbody').on( 'click', 'tr', function () {
                var idx = table.row(this).index();
                var arrData = table.row(idx).data();

                swal({
                    title: "Esta seguro de eliminar este registro?",
                    text: "Una vez eliminado no podra recuperarlo!",
                    icon: "warning",
                    buttons: ["No", "Si"],
                    dangerMode: true,
                    })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "/usuarios/"+arrData['id'],
                            type: 'DELETE',
                            data: {},
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},                  
                            error: function(err) {
                                alertasCustom(4,'Error',err.statusText+" : "+err.responseJSON['message'],'error'); // 1: success, 2:info, 3:warning, 4:error
                            },
                            success: function(res) {
                                alertasCustom(1,'Exito!',res); // 1: success, 2:info, 3:warning, 4:error
                                $('#tablaListado').DataTable().ajax.reload();
                                return false;
                            }
                        });
                    }
                });
            });
        }; 

        function editar(){
            var table = $('#tablaListado').DataTable();
            $('#tablaListado tbody').on( 'click', 'tr', function () {
                var idx = table.row(this).index();
                var arrData = table.row(idx).data();

                $("#nombre").val(arrData['nombre']);
                $("#identificacion").val(arrData['identificacion']);
                $("#telefono").val(arrData['telefono']);
                $("#email").val(arrData['email']);

                $("#idusuario").val(arrData['id']);
                $("#accion").val('2');
            });

            $("#pnlProd").fadeIn(900);
            $("#nombre").focus();
        };        
    </script>  
@endsection