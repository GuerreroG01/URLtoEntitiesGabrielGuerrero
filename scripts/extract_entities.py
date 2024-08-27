import requests
import sys
import json
from google.cloud import language_v1
from google.oauth2 import service_account

def get_entities_from_url(url):
    try:
        credentials = service_account.Credentials.from_service_account_file('D:/Otro/PS/Prueba Pasantias/Key/entityextractor.json')
        client = language_v1.LanguageServiceClient(credentials=credentials)
    
        response = requests.get(url)
        response.raise_for_status() 
        content = response.text
    
        document = language_v1.Document(
            content=content,
            type_=language_v1.Document.Type.PLAIN_TEXT,
        )
    
        response = client.analyze_entities(document=document)
    
        entities = [entity.name for entity in response.entities[:5]]
    
        return {"entities": entities}
    
    except requests.RequestException as e:
        return {"error": f"Request failed: {str(e)}"}
    except Exception as e:
        return {"error": f"An error occurred: {str(e)}"}

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python script.py <URL>")
        sys.exit(1)
    url = sys.argv[1]
    result = get_entities_from_url(url)
    print(json.dumps(result, indent=2))
