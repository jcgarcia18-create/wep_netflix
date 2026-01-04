import os
import psycopg2
from fastapi import FastAPI
from pydantic import BaseModel
from langchain_huggingface import HuggingFaceEmbeddings 
from langchain_chroma import Chroma
from langchain_core.documents import Document 

DB_CONFIG = {
    "dbname": os.getenv("DB_PGSQL_DATABASE", "netflix_auth"),
    "user": os.getenv("DB_PGSQL_USERNAME", "user"),
    "password": os.getenv("DB_PGSQL_PASSWORD", "password"),
    "host": os.getenv("DB_HOST", "postgres_db"),
    "port": os.getenv("DB_PORT", "5432"),
    "client_encoding": "UTF8"
}

app = FastAPI()
vector_db = None 

class Consulta(BaseModel):
    prompt: str

def obtener_peliculas_de_db():
    print(f"🔌 Conectando a PostgreSQL en puerto {DB_CONFIG['port']}...")
    try:
        conn = psycopg2.connect(**DB_CONFIG)
        cur = conn.cursor()
        
        cur.execute("SELECT id, title, description, genre FROM peliculas")
        rows = cur.fetchall()
        
        conn.close()
        print(f"✅ Se encontraron {len(rows)} películas.")
        
        documentos = []
        for row in rows:
            p_id, title, desc, genre = row
            
            title = title if title else "Sin título"
            desc = desc if desc else "Sin descripción"
            genre = genre if genre else "General"

            contenido = f"Título: {title}. Género: {genre}. Sinopsis: {desc}"
            
            doc = Document(page_content=contenido, metadata={"id": p_id})
            documentos.append(doc)
            
        return documentos

    except Exception as e:
        print(f"❌ Error DB: {e}")
        return []

@app.on_event("startup")
async def iniciar_cerebro():
    global vector_db
    print("🧠 Inicializando IA...")
    
    docs = obtener_peliculas_de_db()
    
    if docs:
        print(f"\n👀 CHECK DE DATOS (Lo que la IA leyó de la primera peli):")
        print(f"👉 {docs[0].page_content}\n")

        print("📥 Cargando modelo...")
        embeddings = HuggingFaceEmbeddings(model_name="sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2")
        
        vector_db = Chroma.from_documents(
            documents=docs, 
            embedding=embeddings,
            collection_metadata={"hnsw:space": "cosine"} 
        )
        
        print("🚀 ¡IA lista para recomendar (Modo Coseno Activo)!")

@app.post("/recomendar")
async def recomendar_endpoint(consulta: Consulta):
    if not vector_db:
        return {"movie_ids": []}
    
    palabras_basura = [
        "quiero", "una", "pelicula", "sobre", "ver", "de", "que", "trate", 
        "sea", "busco", "necesito", "algo", "me", "gustaria", "la", "el", "en", "un"
    ]
    texto_limpio = consulta.prompt.lower()
    for p in palabras_basura:
        texto_limpio = texto_limpio.replace(f" {p} ", " ").replace(f"{p} ", " ")
    texto_limpio = texto_limpio.strip()
    
    print(f"\n🔎 Buscando: '{texto_limpio}'")
    
    resultados = vector_db.similarity_search_with_score(texto_limpio, k=10)
    
    if not resultados:
        return {"movie_ids": []}

    mejor_score = resultados[0][1]
    
    print(f"   ℹ️ La mejor coincidencia tiene score: {mejor_score:.4f}")

    umbral_limite = 0.6

    if mejor_score > 0.6:
        print("   ⚠️ Calidad de coincidencia baja (posibles descripciones cortas).")
        print("   🔓 Activando modo flexible...")
        umbral_limite = max(0.70, mejor_score + 0.05) 

    ids_encontrados = []
    
    print(f"   🎯 Umbral aplicado: {umbral_limite:.4f}")

    for doc, score in resultados:
        p_id = doc.metadata["id"]
        
        if score < umbral_limite:
            print(f"   ✅ ACEPTADA (ID: {p_id}) - Score: {score:.4f}")
            ids_encontrados.append(p_id)
        else:
            print(f"   ⛔ CORTE (ID: {p_id}) - Score: {score:.4f}")
            break 
            
    print(f"👉 Total enviadas: {len(ids_encontrados)}\n")
    
    return {"movie_ids": ids_encontrados}