from nltk.tokenize import word_tokenize
from nltk.corpus import wordnet
from nltk.stem import WordNetLemmatizer
import nltk

class NLPSimpleChatbot:
    def __init__(self):
        self.responses = {
            "hola": "¡Hola! ¿Cómo puedo ayudarte hoy?",
            "adiós": "¡Adiós! Que tengas un buen día.",
            "cómo estás": "Estoy bien, gracias por preguntar. ¿Y tú?",
            "qué puedes hacer": "Puedo responder a tus preguntas básicas y conversar contigo.",
            "quién eres": "Soy un simple chatbot creado en Python.",
            "puedes aconsejarme para comprar un smartwatch":"Sí, dime cuales son tus expectativas.",
            "qué es un smartwatch": "Un smartwatch es un reloj inteligente que ofrece diversas funcionalidades además de dar la hora.",
            "qué marcas de smartwatches tienes": "Tengo smartwatches de Apple, Samsung, Garmin, Fitbit, y más.",
        }
        self.lemmatizer = WordNetLemmatizer()

    def lemmatize_sentence(self, sentence):
        tokens = word_tokenize(sentence)
        lemmatized_tokens = [self.lemmatizer.lemmatize(token.lower()) for token in tokens]
        return ' '.join(lemmatized_tokens)

    def get_synonyms(self, word):
        synonyms = set()
        for syn in wordnet.synsets(word):
            for lemma in syn.lemmas():
                synonyms.add(lemma.name())
        return synonyms

    def get_response(self, user_input):
        lemmatized_input = self.lemmatize_sentence(user_input)
        for question in self.responses:
            if question in lemmatized_input or any(synonym in lemmatized_input for synonym in self.get_synonyms(question)):
                return self.responses[question]
        return "Lo siento, no entiendo tu pregunta."

# Descargar recursos de NLTK si es necesario
nltk.download('punkt')
nltk.download('wordnet')
