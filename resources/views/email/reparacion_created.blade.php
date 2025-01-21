<html>

<body>

    <p>Estimado/a {{ $cliente->Nombre . ' ' . $cliente->Apellido }},</p>
    <p>Le informamos que hemos comenzado a reparar su tabla de surf. En breve le enviaremos un correo electrónico cuando su tabla este finalizada si quiere checkear el etado de su reparacion puede acceder a nuestra web y realizar un seguimiento  .</p>
    <p>Gracias por confiar en nosotros.</p>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>

    <table>
        <thead>
            <tr>
                <th>ID de Usuario</th>
                <th>ID de Reparación</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reparacion['User_id'] }}</td>
                <td>{{ $reparacion['id'] }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>;
