<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistema de Ventas Abarrotes" />
        <meta name="author" content="OrlandMejia" />
        <title>Sistema Ventas - @yield('titulo')</title>
        <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <!--agregamos un stack css que normalmente se usan para colocar estilos y js personalizados a la paginas que se heredan
            funciona como una pila la cual deberemos de usar luego con push-->
        @stack('css')
    </head>
<body class="sb-nav-fixed">
    <!-- COLOCACION DE UN COMPONENTE EL CUAL CREAMOS EN COMPONENTES EN VIEWS DONDE ESTÁ ALMACENADO LA BARRA DE NAVEGACIÓN-->
    <x-navigation-header/>
        <div id="layoutSidenav">
            <!--Menu lateral colocado como componente-->
            <x-navigation-sidebar/>
                <div id="layoutSidenav_content">
                    <main>
                        @yield('content')     
                    </main>
                        <!--FOOTER COLOCADO COMO COMPONENTE-->
                        <x-footer/>
                </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <!--FUNCIONA IGUAL QUE STACK CSS SOLO QUE ACA SON JAVASCRIPT PESONALIZADOS Y PARA CADA CSS O JS DEBE DE ESTAR EN UN PUSH-->
        @stack('js')
</body>
</html>
