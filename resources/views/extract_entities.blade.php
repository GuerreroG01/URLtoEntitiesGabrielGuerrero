<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extracción de Entidades</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 300px;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        #results {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Extracción de Entidades</h1>
    <form id="urlForm">
        @csrf
        <input type="text" id="url" name="url" placeholder="Ingrese la URL" required>
        <button type="submit">Enviar</button>
    </form>

    <div id="results"></div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#urlForm').submit(function(e) {
            e.preventDefault();
            let url = $('#url').val();

            $.ajax({
                type: 'POST',
                url: '/extract-entities',
                data: $(this).serialize(),
                success: function(response) {
                    let resultHtml = '';
                    if (response.entities && response.entities.length > 0) {
                        resultHtml += `<h2>Resultados para URL: ${url}</h2>`;
                        resultHtml += '<table><thead><tr><th>Entidad</th></tr></thead><tbody>';
                        response.entities.forEach(function(entity) {
                            resultHtml += `<tr><td>${entity}</td></tr>`;
                        });
                        resultHtml += '</tbody></table>';
                    } else {
                        resultHtml = `<p>No se encontraron entidades para la URL: ${url}.</p>`;
                    }
                    $('#results').html(resultHtml);
                },
                error: function(xhr) {
                    $('#results').html('<p>Error en la solicitud. Inténtalo de nuevo.</p>');
                }
            });
        });
    </script>
</body>
</html>
