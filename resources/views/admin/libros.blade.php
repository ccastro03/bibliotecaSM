@extends('layouts.mainInicio')

@section('contentInicio')
    <div class="pt-5">
        <div id="pnlProd" class="row pb-3">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><span id="titPnl"></span> Libro</h3>
                    </div>
                    <div class="card-body">
                        <div class="row w-100">
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="titulo" class="">Titulo</label>
                                <input name="titulo" id="titulo" type="text" class="form-control" >
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="autor">Autor</label>
                                <input name="autor" id="autor" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="isbn">ISBN</label>
                                <input name="isbn" id="isbn" type="text" class="form-control">
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="categoria" class="">Categoria</label>
                                <input name="categoria" id="categoria" type="text" class="form-control" >
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="cantidad">Cantidad</label>
                                <input name="cantidad" id="cantidad" type="number" class="form-control"  value="5">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 form-group">
                                <label for="fecha_publicacion">Fecha Publicacion</label>
                                <input name="fecha_publicacion" id="fecha_publicacion" type="date" class="form-control">
                            </div>                            

                            <input name="idLibro" id="idLibro" type="text"  hidden>
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
                        <h3 class="card-title">Listado de Libros</h3>

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
                                        <th>Titulo</th>
                                        <th>Auto</th>
                                        <th>ISBN</th>
                                        <th>Categoria</th>
                                        <th>Cantidad</th>
                                        <th>Fecha Publicación</th>
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
                ajax: "{{ url('/libros/show') }}",
                columns: [
                    { data: 'id', visible:false },
                    { data: 'titulo' },                    
                    { data: 'autor' },
                    { data: 'isbn' },
                    { data: 'categoria' },
                    { data: 'cantidad' },
                    { data: 'fecha_publicacion' },
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
            $('#cantidad').val(5);
            $("#titulo").focus();
        };

        function cancelar(){
            limpiarCampos();
            $("#pnlProd").fadeOut(300);
        };

        function limpiarCampos(){
            $("#titulo").val('');
            $("#autor").val('');
            $("#isbn").val('');
            $("#categoria").val('');
            $("#cantidad").val('');
            $("#fecha_publicacion").val('');            
        };

        function guardar(){
            var titulo = document.getElementById("titulo").value;
            var autor = document.getElementById("autor").value;
            var isbn = document.getElementById("isbn").value;
            var categoria = document.getElementById("categoria").value;
            var cantidad = document.getElementById("cantidad").value;
            var fecha_publicacion = document.getElementById("fecha_publicacion").value;            

            var idLibro = document.getElementById("idLibro").value;
            var tipoAcc = document.getElementById("accion").value;        
            var msg = '';          

            if(titulo == ''){
                $('#titulo').addClass("is-invalid");
                msg += '<em>El campo titulo debe estar lleno</em><br>';
            }else{
                $('#titulo').removeClass("is-invalid");
            }

            if(autor == ''){
                $('#autor').addClass("is-invalid");
                msg += '<em>El campo autor debe estar lleno</em><br>';
            }else{
                $('#autor').removeClass("is-invalid");
            }

            if(isbn == ''){
                $('#isbn').addClass("is-invalid");
                msg += '<em>El campo isbn debe estar lleno</em><br>';
            }else{
                $('#isbn').removeClass("is-invalid");
            }

            if(categoria == ''){
                $('#categoria').addClass("is-invalid");
                msg += '<em>El campo categoria debe estar lleno</em><br>';
            }else{
                $('#categoria').removeClass("is-invalid");
            }

            if(cantidad == ''){
                $('#cantidad').addClass("is-invalid");
                msg += '<em>El campo cantidad debe estar lleno</em><br>';
            }else{
                $('#cantidad').removeClass("is-invalid");
            }

            if(fecha_publicacion == ''){
                $('#fecha_publicacion').addClass("is-invalid");
                msg += '<em>El campo fecha_publicacion debe estar lleno</em><br>';
            }else{
                $('#fecha_publicacion').removeClass("is-invalid");
            }

            if(msg == ''){
                if(tipoAcc == '1'){ // 1 - significa que esta insertando
                    $.ajax({
                        url: "/libros",
                        type: 'POST',
                        data: {'titulo':titulo,'autor':autor,'isbn':isbn,'categoria':categoria,'cantidad':cantidad,'fecha_publicacion':fecha_publicacion},
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
                        url: "/libros/"+idLibro,
                        type: 'PUT',
                        data: {'titulo':titulo,'autor':autor,'isbn':isbn,'categoria':categoria,'cantidad':cantidad,'fecha_publicacion':fecha_publicacion},
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
                            url: "/libros/"+arrData['id'],
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

                $("#titulo").val(arrData['titulo']);
                $("#autor").val(arrData['autor']);
                $("#isbn").val(arrData['isbn']);
                $("#categoria").val(arrData['categoria']);
                $("#cantidad").val(arrData['cantidad']);
                $("#fecha_publicacion").val(arrData['fecha_publicacion']);

                $("#idLibro").val(arrData['id']);
                $("#accion").val('2');
            });

            $("#pnlProd").fadeIn(900);
            $("#titulo").focus();
        };        
    </script>  
@endsection