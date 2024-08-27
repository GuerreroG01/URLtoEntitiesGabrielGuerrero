import sys
import requests
import json
from google.cloud import language_v1
from bs4 import BeautifulSoup

def extract_entities(url):
    # Configura el cliente de Google Cloud Language API
    client = language_v1.LanguageServiceClient()

    # Descargar el contenido de la URL
    response = requests.get(url)
    content = response.text

    # Filtrar el contenido HTML para extraer solo el texto
    soup = BeautifulSoup(content, 'html.parser')
    for script_or_style in soup(['script', 'style']):
        script_or_style.decompose()
    text = soup.get_text()

    # Analizar el contenido
    document = language_v1.Document(content=text, type_=language_v1.Document.Type.PLAIN_TEXT)
    response = client.analyze_entities(document=document)

    # Obtener las entidades
    entities = response.entities
    relevant_types = ['ORGANIZATION', 'PERSON', 'LOCATION']  # Filtra por tipos relevantes
    entities_list = [{'name': entity.name, 'type': language_v1.Entity.Type(entity.type_).name, 'salience': entity.salience}
                     for entity in entities if language_v1.Entity.Type(entity.type_).name in relevant_types]

    # Ordenar por salience (relevancia)
    entities_list.sort(key=lambda x: x['salience'], reverse=True)

    # Limitar a las 5 entidades más relevantes
    return entities_list[:5]

if __name__ == "__main__":
    url = sys.argv[1]
    entities = extract_entities(url)
    print(json.dumps({'entities': entities}))
