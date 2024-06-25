from flask import Flask, request, jsonify
from chatbot_logic import NLPSimpleChatbot

app = Flask(__name__)
chatbot = NLPSimpleChatbot()

@app.route('/get_response', methods=['POST'])
def get_response():
    user_input = request.json.get('message')
    response = chatbot.get_response(user_input)
    return jsonify({"response": response})

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)
