<!DOCTYPE HTML>
<html>
	<head>
		<title>Pruebas SM Digital</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

		<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/main.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
		<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">  
		<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">  
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">		

		<meta name="csrf-token" content="{{ csrf_token() }}">

		<script src="{{ asset('js/jquery.min.js') }}"></script>

		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
		<div id="wrapper">
			<!-- Main -->
			<div id="main">
				<div class="inner">
					<div class="content">
						@yield('contentInicio')
					</div>
				</div>
			</div>

			<!-- Sidebar -->
			<div id="sidebar" class="inactive">
				<div class="inner">
					<!-- Menu -->
					<nav id="menu">
						<header class="major">
							<h2>Menu</h2>
						</header>
						<ul>
							<li><a href="/prestamos">Prestamo</a></li>
							<li><a href="/usuarios">Usuarios</a></li>
							<li><a href="/libros">Libros</a></li>
						</ul>
					</nav>
				</div>				
			</div>
		</div>

		<!-- Scripts -->
		<script src="{{ asset('js/browser.min.js') }}"></script>
		<script src="{{ asset('js/breakpoints.min.js') }}"></script>
		<script src="{{ asset('js/util.js') }}"></script>
		<script src="{{ asset('js/main.js') }}"></script>
		<script src="{{ asset('js/sweetAlert.js') }}"></script>
		<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

		<script src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.js"></script>  
  		<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
		<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

		<script>
			function mensajes($titulo,$texto,$tipo){
				swal({
					title: $titulo,
					text: $texto,
					icon: $tipo,
					button: "Aceptar",
				});
			};

			function alertasCustom($tipo,$titulo,$mensaje){
				toastr.options = {"closeButton" : true, "progressBar" : true};
				if ($tipo === 1) {
					toastr.success($mensaje,$titulo);
				} else if ($tipo === 2) {
					toastr.info($mensaje,$titulo);
				} else if ($tipo === 3) {
					toastr.warning($mensaje,$titulo);
				} else if ($tipo === 4) {
					toastr.error($mensaje,$titulo);
				}            
			};			
		</script>
	</body>
</html>