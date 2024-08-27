<!DOCTYPE html>
<html>
<head>
    <title>Extractor de Entidades</title>
</head>
<body>
    <h1>Extractor de Entidades</h1>
    <form id="url-form">
        <label for="url">Enter URL:</label>
        <input type="text" id="url" name="url">
        <button type="submit">Submit</button>
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
                        var table = '<table border="1"><tr><th>Entity</th><th>Type</th><th>Salience</th></tr>';
                        response.entities.forEach(function(entity) {
                            table += '<tr><td>' + entity.name + '</td><td>' + entity.type + '</td><td>' + (entity.salience || 'N/A') + '</td></tr>';
                        });
                        table += '</table>';
                        $('#results').html(table);
                    } else {
                        $('#results').html('<p>Entidades no Encontradas.</p>');
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
