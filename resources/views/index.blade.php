<!DOCTYPE html>
<html>
<head>
    <title>Extractor de Entidades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #4cae4c;
        }
        #results {
            margin-top: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f8f8;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        p {
            color: #555;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Extractor de Entidades</h1>
    <form id="url-form">
        <label for="url">Introduce URL:</label>
        <input type="text" id="url" name="url" placeholder="Escribe la URL aquí...">
        <button type="submit">Enviar</button>
    </form>
    <div id="results"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#url-form').on('submit', function(event) {
            event.preventDefault();
            
            var url = $('#url').val();
            
            $.ajax({
                url: '/extract-entities',
                method: 'POST',
                data: {
                    url: url,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.entities && response.entities.length > 0) {
                        var resultsHeader = '<p>Entidades Obtenidas de: <strong>' + url + '</strong></p>';
                        var table = '<table><tr><th>Entidad</th><th>Tipo</th><th>Saliencia</th></tr>';
                        response.entities.forEach(function(entity) {
                            table += '<tr><td>' + entity.name + '</td><td>' + entity.type + '</td><td>' + (entity.salience || 'N/A') + '</td></tr>';
                        });
                        table += '</table>';
                        $('#results').html(resultsHeader + table);
                    } else {
                        $('#results').html('<p>No se encontraron entidades para: <strong>' + url + '</strong></p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    $('#results').html('<p>Error procesando URL.</p>');
                }
            });
        });
    });
    </script>
</body>
</html>
