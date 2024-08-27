import sys
import json
from playwright.sync_api import sync_playwright
from google.cloud import language_v1
from bs4 import BeautifulSoup

def get_page_content(url):
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        page = browser.new_page()
        page.goto(url)

        # Esperar a que la página cargue completamente
        page.wait_for_load_state('networkidle')

        content = page.content()
        print("Contenido cargado correctamente.")
        browser.close()

    return content

def extract_entities(url):
    client = language_v1.LanguageServiceClient()

    content = get_page_content(url)
    if not content:
        return []

    soup = BeautifulSoup(content, 'html.parser')
    for script_or_style in soup(['script', 'style']):
        script_or_style.decompose()
    text = soup.get_text()

    document = language_v1.Document(content=text, type_=language_v1.Document.Type.PLAIN_TEXT)
    response = client.analyze_entities(document=document)

    entities = response.entities
    entities_list = [{'name': entity.name, 'type': language_v1.Entity.Type(entity.type_).name, 'salience': entity.salience}
                     for entity in entities]

    entities_list.sort(key=lambda x: x['salience'], reverse=True)

    return entities_list[:5]

if __name__ == "__main__":
    url = sys.argv[1]
    entities = extract_entities(url)
    print(json.dumps({'entities': entities}))
