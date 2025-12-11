<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clients Export</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>

<h2>
    Clients List - {{ ucfirst($type) }} - {{ $anio }}/{{ $mes }}
</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>IP Address</th>
            <th>Contract</th>
        </tr>
    </thead>

    <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->nombre }} {{ $client->apellido }}</td>
                <td>{{ $client->ip }}</td>
                <td>{{ $client->contract->megabytes ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
