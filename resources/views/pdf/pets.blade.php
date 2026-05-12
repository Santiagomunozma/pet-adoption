<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Mascotas</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
        }
        h1 {
            color: #1e40af;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #3b82f6;
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .status-disponible {
            color: #16a34a;
            font-weight: bold;
        }
        .status-adoptado {
            color: #dc2626;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte General de Mascotas</h1>
        <p>Sistema de Gestión de Adopciones - {{ now()->timezone('America/Bogota')->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Especie</th>
                <th>Raza</th>
                <th>Edad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pets as $pet)
            <tr>
                <td><strong>{{ $pet->name }}</strong></td>
                <td>{{ $pet->species->name }}</td>
                <td>{{ $pet->breed ?? 'N/A' }}</td>
                <td>{{ $pet->age }} años</td>
                <td class="status-{{ $pet->status }}">
                    {{ ucfirst($pet->status) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado automáticamente por el Gestor de Adopciones
    </div>
</body>
</html>