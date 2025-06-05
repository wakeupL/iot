<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page 
        {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 20px;
        }
        .contenedor {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0px;
        }
        .fecha-hora {
            font-size: 18px;
        }
        .qr {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    
    @foreach($etiquetas as $etiqueta)
        <div class="contenedor">
            <div class="qr">
                <img src="data:image/png;base64,{{ $etiqueta['qr'] }}" width="80" alt="QR">
            </div>
            <div class="texto">
                {{ $etiqueta['cliente'] . ' - NV: ' . $etiqueta['nota_venta'] }}
                <br>
                {{ $etiqueta['texto'] }}
            </div>
            <div class="fecha-hora">
                {{ $etiqueta['fecha_hora'] }}
            </div>
        </div>
    @endforeach
</body>
</html>
