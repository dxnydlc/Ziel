<?php
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "spanish");

$tag    = '';
$tag    = date('d-m-y H-i-s');
$tag    = sha1($tag);
$rand   = '';
$rand   = '?v='.rand(0,9999999);

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ziel - Ayuda</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <link href="../dist/css/estilos.css" rel="stylesheet">
    
    <!-- Animated -->
    <link rel="stylesheet" href="../js/animated/animate.css">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <section class="container" >
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >Ayuda Ziel 1.0</h1>
                </div>
            </div>
        </section>
        <!-- /.container -->

        <section class="container" >
            <div class="col-lg-3">
                <div class="list-group wow bounceInLeft">
                    <a href="#Login" class="list-group-item " >login al sistema</a>
                    <a href="#mantenimiento" class="list-group-item " >Mantenimiento</a>
                    <a href="#ventas" class="list-group-item " >Ventas y pre ventas</a>
                    <a href="#oc" class="list-group-item " >Orden de compra y Parte de entrada</a>
                    <a href="#promociones" class="list-group-item " >Promociones</a>
                    <a href="#acerca" class="list-group-item " >Acerca de</a>
                </div>
                <!-- /list-group -->
            </div>
            <!-- /col-lg-4 -->
            <div class="col-lg-9">

                <div id="login" class="" >
                    <h2 id="Login" >Login al sistema</h2>
                    <p class="wow fadeInUp" >Considerar <br/>
                    Sólo los usuarios del tipo administrador pueden agregar, editar y/o anular usuarios del sistema.<br/>
                    Los documentos que este usuario cree en el sistema se guardarán con su ID.<br/>
                    Al iniciar el sistema aparecerá la ventana de Login</p>
                    
                    <img src="../images/help/login/login-01.png" class="img-responsive wow bounceInRight centrado" >

                    <p class="wow fadeInUp" >
                        Al ingresar al sistema podrá ver el dashboard los datos del sistema, así como de todos sus movimientos de caja del día
                    </p>
                    <img src="../images/help/login/login-02.png" class="img-responsive wow bounceInRight centrado" >
                    
                    <hr/>
                    <p>El menú de un administrado tiene más opciones que el menú de un usuario Cajero.</p>

                    <div class="row wow fadeInUp ">
                        <div class="col-lg-6">
                            <img src="../images/help/login/menu-admin.png" class="img-responsive wow bounceInRight centrado" >
                            <p class="text-center" >Menu de usuario Administrador</p>
                        </div>
                        <div class="col-lg-6">
                            <img src="../images/help/login/menu-cajero.png" class="img-responsive wow bounceInRight centrado" >
                            <p class="text-center" >Menu de usuario Cajeero</p>
                        </div>
                    </div>
                    
                    <div class="row wow fadeInUp ">
                        <div class="col-lg-6">
                            <p>El administrador podrá acceder a:</p>
                            <ul class="list-unstyled" >
                                <li>Acceder al Dashboar</li>
                                <li>Reportes</li>
                                <li>Inventario</li>
                                <li>Promociones</li>
                                <li>Pre venta</li>
                                <li>Ordenes de compra</li>
                                <li>Ventas</li>
                                <li>Mantenimiento</li>
                                <li>Ayuda</li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <p>El cajer podrá acceder a:</p>
                            <ul class="list-unstyled">
                                <li>Acceder al Dashboard</li>
                                <li>Reportes</li>
                                <li>Pre venta</li>
                                <li>Ventas</li>
                                <li>Ayuda</li>
                            </ul>
                        </div>
                    </div>
                    
                    <hr/>

                    <h3>Login y dashboard<small> vídeo de instrucción</small></h3>
                    <div class="embed-responsive embed-responsive-16by9 wow bounceInRight ">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/DG9ybolxl0Q?rel=0"></iframe>
                    </div>
                    <p>https://www.youtube.com/watch?v=DG9ybolxl0Q</p>
                </div>
                <!-- / #login -->

                <div id="mantenimiento" >
                    
                    <h2>Mantenimiento</h2>
                    <p class="wow fadeInUp" >El mantenimiento del sistema solo está permitido a los administradores, le menú mantenimiento costa de:</p>

                    <img src="../images/help/mant/mant-01.png" class="img-responsive wow bounceInRight centrado" >

                    <br/>

                    <h3 id="um" class="wow bounceInRight" ><u>Unidades de Medida</u></h3>

                    <p class="wow bounceInRight" >Las unidades de medida son datos de un producto, consta de una descripción y de una abreviatura, para ver el listado tiene que entrar a menú mantenimiento  y luego en unidades de medida.<br/>
                    Al ingresar aparecerán las unidades de medida actual.</p>

                    <br/>
                    <img src="../images/help/mant/um-01.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >Para agregar una nueva damos click en el boton "Agregar" se abrirá un popup escribirmos nombre y abreviatura y click en guardar.</p>
                    
                    <img src="../images/help/mant/um-02.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >Para editar damos click a una unidad de medida del listado, automáticamente abrirá el popup con los datos cargados para ser modificados.</p>

                    <img src="../images/help/mant/um-03.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <h3 id="clase" class="wow bounceInRight" ><u>Clases de producto</u></h3>

                    <p class="wow bounceInRight" >Las clases de producto sirven para categorizar a un producto, un producto puede tener más de una clase asignada, para ver las clases de producto entramos a: mantenimiento / clases de producto, al ingresar aparecerán todas las clases creadas hasta el momento así como su estado.</p>
                    
                    <br/>
                    <img src="../images/help/mant/cls-01.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >Para agregar una nueva clase damos click en el boton "Agregar" aparecerá un popup, agregamos el nombre y luego click en guardar.</p>
                    
                    <img src="../images/help/mant/cls-02.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >Para editar damos click al nombre de una clase, se abrirá un popup con los datos de nuestra clase luego click en guardar para actualizar.</p>

                    <img src="../images/help/mant/cls-03.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <h3 id="generico" class="wow bounceInRight" ><u>Genericos</u></h3>

                    <p class="wow bounceInRight" >Los genericos son necesarios para el producto, este indica una categoría medica sin embargo hay un generico agregado por defecto en el sistema con el nombre de "ninguno", para ingresar a los genericos deberá ingresar a: mantenimiento / genericos al ingresar verá el listado de todos los genericos y sus respectivos estados.</p>
                    
                    <br/>
                    <img src="../images/help/mant/gen-01.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >Para agregar un nuevo generico damos click en el boton "Agregar" aparecerá un popup, agregamos el nombre y luego click en guardar.</p>
                    
                    <img src="../images/help/mant/gen-02.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >Para editar damos click al nombre de un generico, se abrirá un popup con los datos de nuestra clase luego click en guardar para actualizar.</p>

                    <img src="../images/help/mant/gen-03.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <h3 class="wow bounceInRight" ><u>Productos</u></h3>

                    <p class="wow bounceInRight" >Antes de crear un producto deberá asegurarse que exista tanto la <a href="#clase">clase</a>, <a href="#um">unidad de medida</a> y <a href="#generico">generico</a> estos son necesarios para un producto, para entrar a editar o crear un producto entramos a: mantenimiento / productos al ingresar veremos la lista paginada de productos actuales.</p>

                    <br/>
                    <img src="../images/help/mant/prod-01.png" class="img-responsive wow bounceInRight centrado" >
                    <p class="wow bounceInRight" >La columna precio que se muestra es la del precio de venta</p>
                    <br/>

                    <p class="wow bounceInRight" >Si queremos agregar un producto tenemos que dar click en el boton "agregar" esto nos llevará a una página nueva donde podremos crear nuestro producto.</p>
                    
                    <br/>
                    <img src="../images/help/mant/prod-02.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >En el primer bloque tenemos la <strong>Clase de producto</strong> seguido de <strong>generico</strong>, si no deseamos ninguno elegimos el item "ninguno" en el combo de generico, para el caso de <strong>Producto destacado</strong> este producto tendrá una marca cuando el usuario lo busque en el sitema.</p>

                    <br/>
                    <img src="../images/help/mant/prod-03.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >En el segundo bloque seleccionamos la <strong>unidad de medida</strong>, por defecto esta en "unidad" pero podemos seleccionar cualquier otra, la equivalencia es para indicar a cuantas unidades equivale este producto.<br/>
                    Nombre de producto, el nombre con el que se buscará y mostrará el producto en el sistema este campo es <u>necesario y no puede ir vacio</u>, los demás campos son opcionales.</p>

                    <br/>
                    <img src="../images/help/mant/prod-04.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow bounceInRight" >En el último bloque se ingresará el precio del producto, tanto de compra como de venta, el porcentaje de utilidad de calculará automáticamente y puede ser cambiado desde este formulario o desde las <a href="oc">ordenes de compra</a><br/><br/>
                    Click en guardar cambios para terminar.</p>
    
                    <hr/>

                    <h3>Mantenimiento <small> vídeo de instrucción</small></h3>
                    <div class="embed-responsive embed-responsive-16by9 wow bounceInRight ">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/_3vRHaCrxSk?rel=0"></iframe>
                    </div>
                    <p>https://www.youtube.com/watch?v=_3vRHaCrxSk</p>
                </div>
                <!-- /#mantenimiento -->

                <div id="ventas">
                    <h2>Ventas y pre ventas</h2>
                    <p class="wow fadeInUp" >Como hacer una venta directamente o hacer un documento de ventas desde una preventa así mismo como copiar documentos.</p>
                    
                    <h4>Pre venta</h4>

                    <p class="wow fadeInUp" >Para ingresar a Pre -ventas vamos al menú de la izquierda "Pre-venta", todos los usuarios lo tienen, al ingresar se muestran las preventas generadas y los botones de comando de la derecha<br/>
                    <br/>Copiar el documento, es decir todos los productos contenidos así como el cliente será copiado en un nuevo documento con el ID del usuario actual y la fecha actual.
                    </p>
                    <img src="../images/help/ventas/venta-copiar.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>
                    <p class="wow fadeInUp" >Anular el documento, este boton anulará el documento</p>
                    <img src="../images/help/ventas/venta-anular.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>
                    <p class="wow fadeInUp" >Emitir el documento, al presionar este boton se activará un popup para seleccionar el tipo de documento y el correlativo del mismo para este.</p>
                    <img src="../images/help/ventas/venta-emitir.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <br/>
                    <img src="../images/help/ventas/ventas01.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow fadeInUp" >Para agregar un nuevo documento de Pre venta, dar click en el boton "Nuevo Pre-venta" esto nos llevará a una nueva página para agregar el detalle de la misma.</p>

                    <br/>
                    <img src="../images/help/ventas/ventas-02.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p class="wow fadeInUp" >En la parte superior aparecerá la lista de "promociones vigentes" si es que las hay, en el primer bloque elegimos el cliente así como la fecha, por defecto es la fecha actual, para agregar los productos damos click en el boton de dice "+ Producto" 
                        el cual abrirá un nuevo bloque para elegir el producto.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-03.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>En el primer cuadro se digita el nombre del producto al escribir más de dos letras se despliega una lista con los productos que contienen esas el texto ingresado ya sea que el texto este al inicio al final o se parte de una palabra completa, se recomienda buscar por la palbra menos común.</p>

                    <br/>
                    <div class="row">
                        <div class="col-lg-6">
                            <img src="../images/help/ventas/venta-04.png" class="img-responsive wow bounceInRight centrado" >
                            <p>En este caso se esta buscando con el texto "ast" y trae dos resultados, uno de ellos tiene el logo obscuro ese producto ha sido resaltado puede revisar la parte de manenimiento de productos para modificarlo.</p>
                        </div>
                        <!-- /.col-lg-6 -->
                        <div class="col-lg-6">
                            <img src="../images/help/ventas/venta-05.png" class="img-responsive wow bounceInRight centrado" >
                            <p>En este otro caso se busco por el texto "do" y trajo más resultados de lo esperado.</p>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                    <br/>
                    <p>Para ambos casos luego de escribir en la lista aparecerá los resultados y podra moverse entre item e item con las teclas flecha<br/>
                    Cada item contiene: Nombre del producto, unidad de medida, precio y stock actual.<br/>
                    Al ubicarnos en el item que queremos pulsamos la tecla "enter" y esto nos llevará a la caja de texto "cantidad" colocamos el número de productos que el cliente llevará y volvemos a pulsar "enter" luego el cursor se ubicará en el boton tipo link "Agregar" un "enter" más y el producto será agregado a la lista.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-06.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>El producto ahora esta en la lista, para el caso de este producto estaba sujeto a una promoción y abajo del nombre aparece el nombre de la promoción y el precio anterior.<br/>
                    Considere: El documento aún no ha sido guardado si da click en regresar los productos agregados se perderán, antes de regresar en un documento debe dar click en guardar.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-07.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Una vez guardado en el caso de las pre ventas aparecerá un cuadro abajo en el cual podremos especificar a donde queremos mandar esta preventa, en este caso se enviará a una boleta de venta no colocaré correlativo por que quiero que el sistema lo siga automáticamente entonces doy click en "generar".</p>

                    <br/>
                    <img src="../images/help/ventas/venta-08.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Este proceso también se puede hacer desde el listado de Pre venta haciendo click en "emitir documento" y aparecerá un popup.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-09.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Esto nos va a llevar al documento de ventas seleccionado, boleta para este caso, con el id auto generado y especificando desde que número de Pre venta se generó el mismo.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-11.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <h4>Ventas</h4>

                    <p>Para el caso de las ventas directas sin un documento de Pre venta de por medio podrá hacerlo desde el menú izquierdo "Ventas" todos los usuarios tienen este menú.<br/>
                    Al ingresar se mostrará todas las ventas tipos, sus estados, total y el usuario que las ha creado</p>

                    <br/>
                    <img src="../images/help/ventas/venta-12.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Para generar un documento nuevo damos click en "Nuevo Documento" y se despliega un menú para seleccionar el tipo de documento que desea generar, Boleta, Factura, Recibo.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-13.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Para este caso vamos a generar una boleta de venta, el sistema nos lleva a nueva boleta, especificamos el cliente si es que hay uno la fecha y agregamos los productos a la lista tal como se explica en Pre venta.<br/>
                    En la parte superior aparecerá una lista con las promociones actuales vigentes.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-14.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>En la parte inferior se podrá colocar la forma de pago, si el pago es en efectivo deberá colocar el monto con el que el cliente paga para calcular el vuelto.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-15.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Ahora esta venta aún no ha movido los productos del stock, para ello debemos dar click en "Cerrar Boleta" de esa forma el stock se mueve y el documento queda cerrado para no ser modificado por ningún otro usuario</p>

                    <br/>
                    <img src="../images/help/ventas/venta-16.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Al volver a la lista de las ventas, observaremos la boleta con estado cerrado y el usuario que la ha creado, para anular hay que dar click en el boton con la X, podemos copiar la misma con el boton copiar.</p>

                    <br/>
                    <img src="../images/help/ventas/venta-17.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <hr/>
                    <h3>Ventas y pre ventas <small> vídeo de instrucción</small></h3>
                    <div class="embed-responsive embed-responsive-16by9 wow bounceInRight ">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zuMrZkkAXQo?rel=0"></iframe>
                    </div>
                    <p>https://www.youtube.com/watch?v=zuMrZkkAXQo</p>
                </div>
                <!-- /#ventas -->

                <div id="oc">
                    <h2>Ordenes de compra y Parte de Entrada</h2>

                    <p>Esta opción sirve para aumentar el stock de los productos, ya sea desde una Orden de compra o directamente desde un parte de entrada, así mismo va a modificar los precios de los productos.<br/>
                        Para ingresar tiene que dar click en el menu de la izquierda "Ordenes de Compra", sólo los administradores tienen esta opción<br/><br/>
                        Al ingresar veremos todas las ordenes de compra y sus respectivos estados así como los Partes de entrada a los que están asignados (PE) y los botones de comando para "anular, copiar e ingresar stock"<br/>

                        Para agregar una nueva orden de compra damos click en el boton "Nueva Orden de compra", esto nos llevará a otra página para crear la orden de compra.</p>

                    <br/>
                    <img src="../images/help/oc/oc-01.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Una vez adentro seleccionamos el proveedor y la fecha actual, damos click en el boton "+ Producto" para agregar un nuevo producto.<br/>
                        Seleccionamos el producto, ingresamos su cantidad el precio de compra y el precio de venta el sitema calculará la utilidad esto afectará al precio de venta al publico una vez confirmado el Parte de entrada.</p>
                    
                    <br/>
                    <img src="../images/help/oc/oc-02.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Llenamos todos los productos necesarios y damos click en guardar, el sistema asignará un Id automaticamente.</p>

                    <br/>
                    <img src="../images/help/oc/oc-03.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Regresamos al listado de las ordenes de compra y damos click en el boton de comando para Ingresar esta orden de compra, un popup nos pedirá confirmar este ingreso.</p>

                    <br/>
                    <img src="../images/help/oc/oc-04.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Al confirmar el sistema nos llevará al Parte de entrada generado, <strong>aun no se ha ingresado al stock y tampoco se han cambiado los precios</strong> </p>

                    <br/>
                    <img src="../images/help/oc/oc-06.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Al dar click en el boton "Cerrar Parte de Entrada" se moverán los stock de los productos y los respectivos precios.</p>

                    <br/>
                    <img src="../images/help/oc/oc-05.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <hr/>
                    <h3>Orden de compra y Parte de entrada <small> vídeo de instrucción</small></h3>
                    <div class="embed-responsive embed-responsive-16by9 wow bounceInRight ">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/NHDbvh6cb7w?rel=0"></iframe>
                    </div>
                    <p>https://www.youtube.com/watch?v=zuMrZkkAXQo</p>

                </div>
                <!-- /#ordenes compra PE -->
                
                <div id="promociones">
                    <h2>Promociones</h2>
                    <p>Las promociones se pueden especificar por rango de fechas o dias puntuales, para el caso de los días puntuales estas rigen todo el año se debe anular una promoción para evitar problemas<br/><br/>
                        Si en caso un producto este incluido en dos o más promociones el sistema buscará la promoción más baja para el cliente y la asignará.</p>

                    <p>Para ingresar al menú damos click en el menu de la izquierda "Promociones" sólo los administradores tienen acceso a ella.</p>

                    <br/>
                    <img src="../images/help/promo/prom-01.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Para agregar una Nueva damos click en "+ Nueva promocion", llenamos el título de la misma en caso sea una clase de producto o un producto puntual si el precio será por porcentaje o precio fijo el rango de fechas o días puntuales y luego damos click en "Guardar" <strong>las promociones no se modifican una vez guaradas no se podrán modificar.</strong></p>

                    <br/>
                    <img src="../images/help/promo/prom-02.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <p>Para el caso de dias especificos se podrá especificar que días funcionará esa promoción pero son vigentes todo el año así que si desea usarla, digamos un mes, luego de terminado el periodo el administrador deberá anular esta promoción.</p>

                    <br/>
                    <img src="../images/help/promo/prom-03.png" class="img-responsive wow bounceInRight centrado" >
                    <br/>

                    <hr/>
                    <h3>Promociones <small> vídeo de instrucción</small></h3>
                    <div class="embed-responsive embed-responsive-16by9 wow bounceInRight ">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/p-Qnust2QlE?rel=0"></iframe>
                    </div>
                    <p>https://www.youtube.com/watch?v=p-Qnust2QlE</p>
                </div>
                <!-- /promociones -->

                <div id="acerca">
                    <h2 class="text-center page-header" >Ziel version 1.0 Lomo saltado - Junio 2015</h2>
                    <p>Este sistema esta desarrollado en PHP<br/>Base de datos en MySQL<br/>Front end esta basado en Bootstrap v3.3.2 (http://getbootstrap.com)</p>
                    <p>Programador: Dany de la Cruz @drdelacruzm</p>
                    <p>Todos los derechos reseervados.</p>

                    <hr/>
                    <h3>Videos <small> de instrucción</small></h3>
                    <div class="embed-responsive embed-responsive-16by9 wow bounceInRight ">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/videoseries?list=PLhRpJ1pblNq0bDfFnqnarvRrI9WzP9E7s?rel=0"></iframe>
                    </div>
                    <p>https://www.youtube.com/watch?v=DG9ybolxl0Q&index=1&list=PLhRpJ1pblNq0bDfFnqnarvRrI9WzP9E7s</p>

                </div>

            </div>
            <!-- /col-lg-4 -->
        </section>

        <section class="container">
            <footer>
                <div class="row">
                    <div class="col-lg-12">
                        <small>Pamina 2015 version 1.0- Lomo saltado.</small>
                    </div>
                </div>
            </footer>
        </section>

            
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- WOW -->
    <script type="text/javascript" src="../js/animated/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/ayuda.js<?php echo $rand; ?>"></script>

</body>

</html>
